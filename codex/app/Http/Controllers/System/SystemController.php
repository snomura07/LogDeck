<?php

namespace App\Http\Controllers\System;

use App\Actions\System\CreateSystemAction;
use App\Actions\System\GetSystemListAction;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function index(GetSystemListAction $getSystemListAction): View
    {
        return view('systems.index', [
            'systems' => $getSystemListAction->execute(),
        ]);
    }

    public function create(): View
    {
        return view('systems.create');
    }

    public function store(Request $request, CreateSystemAction $createSystemAction): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $createSystemAction->execute($validated);

        return redirect()
            ->route('systems.index')
            ->with('status', 'システムを登録しました。');
    }
}
