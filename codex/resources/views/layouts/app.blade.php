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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
