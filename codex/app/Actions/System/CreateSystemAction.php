<?php

namespace App\Actions\System;

use App\Models\LogSystem;
use Illuminate\Support\Str;

class CreateSystemAction
{
    public function execute(array $validated): LogSystem
    {
        return LogSystem::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'api_path' => Str::lower(Str::random(16)),
        ]);
    }
}
