<?php

namespace App\Http\Controllers;

use App\Models\LogSystem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SystemController extends Controller
{
    public function index(): View
    {
        $systems = LogSystem::query()
            ->withCount('logs')
            ->latest()
            ->paginate(15);

        return view('systems.index', ['systems' => $systems]);
    }

    public function create(): View
    {
        return view('systems.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        LogSystem::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'api_path' => Str::lower(Str::random(16)),
        ]);

        return redirect()
            ->route('systems.index')
            ->with('status', 'システムを登録しました。');
    }
}
