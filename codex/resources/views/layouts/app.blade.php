<!DOCTYPE html>
<html lang="ja" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LogDeck') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --ld-bg: #0b1020;
            --ld-panel: rgba(15, 23, 42, 0.82);
            --ld-panel-border: rgba(148, 163, 184, 0.14);
            --ld-accent: #f97316;
            --ld-accent-soft: rgba(249, 115, 22, 0.18);
            --ld-text: #e2e8f0;
            --ld-muted: #94a3b8;
        }
        body {
            min-height: 100vh;
            color: var(--ld-text);
            font-family: "Space Grotesk", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(249, 115, 22, 0.14), transparent 30%),
                radial-gradient(circle at top right, rgba(14, 165, 233, 0.12), transparent 25%),
                linear-gradient(180deg, #020617 0%, #0f172a 100%);
        }
        .ld-navbar,
        .ld-card {
            background: var(--ld-panel);
            border: 1px solid var(--ld-panel-border);
            backdrop-filter: blur(12px);
            box-shadow: 0 24px 80px rgba(2, 6, 23, 0.35);
        }
        .ld-brand {
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 700;
        }
        .ld-stat {
            border-left: 4px solid var(--ld-accent);
        }
        .table > :not(caption) > * > * {
            background: transparent;
            color: var(--ld-text);
        }
        .form-control,
        .form-select {
            background: rgba(15, 23, 42, 0.72);
            border-color: rgba(148, 163, 184, 0.2);
            color: var(--ld-text);
        }
        .form-control::placeholder {
            color: var(--ld-muted);
        }
        .btn-primary {
            background: var(--ld-accent);
            border-color: var(--ld-accent);
        }
        .badge.ld-info { background: rgba(14, 165, 233, 0.2); color: #7dd3fc; }
        .badge.ld-warn { background: rgba(245, 158, 11, 0.2); color: #fcd34d; }
        .badge.ld-error { background: rgba(239, 68, 68, 0.2); color: #fca5a5; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg ld-navbar sticky-top">
        <div class="container py-2">
            <a class="navbar-brand ld-brand text-light" href="{{ route('dashboard') }}">
                <i class="bi bi-journal-richtext text-warning"></i> LogDeck
            </a>
            <div class="navbar-nav ms-auto gap-2">
                <a class="nav-link text-light" href="{{ route('dashboard') }}">Logs</a>
                <a class="nav-link text-light" href="{{ route('systems.index') }}">Systems</a>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-lg-5">
        @if (session('status'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
