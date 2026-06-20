<?php

namespace App\Http\Controllers\Api\Log;

use App\Actions\Api\Log\IngestLogEntryAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogIngestController extends Controller
{
    public function store(Request $request, string $path, IngestLogEntryAction $ingestLogEntryAction): JsonResponse
    {
        $validated = $request->validate([
            'level' => ['required', 'string', 'in:INFO,WARN,ERROR'],
            'message' => ['required', 'string'],
        ]);

        if (! $ingestLogEntryAction->execute($path, $validated)) {
            return response()->json([
                'result' => 'error',
                'message' => 'system not found',
            ], 404);
        }

        return response()->json([
            'result' => 'ok',
        ]);
    }
}
