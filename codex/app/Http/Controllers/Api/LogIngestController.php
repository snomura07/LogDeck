<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogEntry;
use App\Models\LogSystem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogIngestController extends Controller
{
    public function store(Request $request, string $path): JsonResponse
    {
        $system = LogSystem::query()->where('api_path', $path)->first();

        if (! $system) {
            return response()->json([
                'result' => 'error',
                'message' => 'system not found',
            ], 404);
        }

        $validated = $request->validate([
            'level' => ['required', 'string', 'in:INFO,WARN,ERROR'],
            'message' => ['required', 'string'],
        ]);

        LogEntry::create([
            'system_id' => $system->id,
            'level' => $validated['level'],
            'message' => $validated['message'],
            'received_at' => now(),
        ]);

        return response()->json([
            'result' => 'ok',
        ]);
    }
}
