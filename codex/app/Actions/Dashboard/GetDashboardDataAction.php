<?php

namespace App\Actions\Dashboard;

use App\Models\LogEntry;
use App\Models\LogSystem;
use Illuminate\Support\Carbon;

class GetDashboardDataAction
{
    public function execute(array $filters): array
    {
        $sort = $filters['sort'] ?? 'received_at_desc';
        $direction = $sort === 'received_at_asc' ? 'asc' : 'desc';
        $normalizedFilters = $filters;

        if (! empty($filters['date_from'])) {
            $normalizedFilters['date_from'] = Carbon::parse($filters['date_from'])->format('Y-m-d H:i:s');
        }

        if (! empty($filters['date_to'])) {
            $normalizedFilters['date_to'] = Carbon::parse($filters['date_to'])->format('Y-m-d H:i:s');
        }

        return [
            'logs' => LogEntry::query()
                ->with('system')
                ->filter($normalizedFilters)
                ->orderBy('received_at', $direction)
                ->paginate(20)
                ->withQueryString(),
            'systems' => LogSystem::query()->orderBy('name')->get(),
            'summary' => [
                'systems' => LogSystem::count(),
                'logs' => LogEntry::count(),
                'errors' => LogEntry::query()->where('level', 'ERROR')->count(),
            ],
        ];
    }
}
