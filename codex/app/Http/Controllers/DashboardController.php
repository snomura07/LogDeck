<?php

namespace App\Http\Controllers;

use App\Models\LogEntry;
use App\Models\LogSystem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'system_id' => ['nullable', 'integer', 'exists:systems,id'],
            'level' => ['nullable', 'string', 'in:INFO,WARN,ERROR'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'message' => ['nullable', 'string', 'max:1000'],
            'sort' => ['nullable', 'string', 'in:received_at_asc,received_at_desc'],
        ]);

        $sort = $filters['sort'] ?? 'received_at_desc';
        $direction = $sort === 'received_at_asc' ? 'asc' : 'desc';
        $normalizedFilters = $filters;

        if (! empty($filters['date_from'])) {
            $normalizedFilters['date_from'] = Carbon::parse($filters['date_from'])->format('Y-m-d H:i:s');
        }

        if (! empty($filters['date_to'])) {
            $normalizedFilters['date_to'] = Carbon::parse($filters['date_to'])->format('Y-m-d H:i:s');
        }

        $logs = LogEntry::query()
            ->with('system')
            ->filter($normalizedFilters)
            ->orderBy('received_at', $direction)
            ->paginate(20)
            ->withQueryString();

        return view('dashboard.index', [
            'filters' => $filters,
            'logs' => $logs,
            'systems' => LogSystem::query()->orderBy('name')->get(),
            'summary' => [
                'systems' => LogSystem::count(),
                'logs' => LogEntry::count(),
                'errors' => LogEntry::where('level', 'ERROR')->count(),
            ],
        ]);
    }
}
