<?php

namespace App\Actions\System;

use App\Models\LogSystem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetSystemListAction
{
    public function execute(): LengthAwarePaginator
    {
        return LogSystem::query()
            ->withCount('logs')
            ->latest()
            ->paginate(15);
    }
}
