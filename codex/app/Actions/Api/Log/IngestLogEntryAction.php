<?php

namespace App\Actions\Api\Log;

use App\Models\LogEntry;
use App\Models\LogSystem;

class IngestLogEntryAction
{
    public function execute(string $path, array $validated): bool
    {
        $system = LogSystem::query()->where('api_path', $path)->first();

        if (! $system) {
            return false;
        }

        LogEntry::create([
            'system_id' => $system->id,
            'level' => $validated['level'],
            'message' => $validated['message'],
            'received_at' => now(),
        ]);

        return true;
    }
}
