@extends('layouts.app')

@section('content')
    <section class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card ld-card ld-stat h-100">
                <div class="card-body">
                    <div class="text-secondary small mb-2">Registered Systems</div>
                    <div class="display-6 fw-semibold">{{ $summary['systems'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card ld-card ld-stat h-100">
                <div class="card-body">
                    <div class="text-secondary small mb-2">Total Logs</div>
                    <div class="display-6 fw-semibold">{{ $summary['logs'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card ld-card ld-stat h-100">
                <div class="card-body">
                    <div class="text-secondary small mb-2">Error Logs</div>
                    <div class="display-6 fw-semibold">{{ $summary['errors'] }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="card ld-card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h4 mb-0">Log Search</h1>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">Reset</a>
            </div>
            <form method="get" class="row g-3">
                <div class="col-12 col-md-4">
                    <label class="form-label">System</label>
                    <select name="system_id" class="form-select">
                        <option value="">All Systems</option>
                        @foreach ($systems as $system)
                            <option value="{{ $system->id }}" @selected(($filters['system_id'] ?? null) == $system->id)>
                                {{ $system->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label">Level</label>
                    <select name="level" class="form-select">
                        <option value="">All</option>
                        @foreach (['INFO', 'WARN', 'ERROR'] as $level)
                            <option value="{{ $level }}" @selected(($filters['level'] ?? null) === $level)>{{ $level }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label">Sort</label>
                    <select name="sort" class="form-select">
                        <option value="received_at_desc" @selected(($filters['sort'] ?? 'received_at_desc') === 'received_at_desc')>Newest</option>
                        <option value="received_at_asc" @selected(($filters['sort'] ?? null) === 'received_at_asc')>Oldest</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label">From</label>
                    <input type="datetime-local" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-control">
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label">To</label>
                    <input type="datetime-local" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-control">
                </div>
                <div class="col-12 col-md-9">
                    <label class="form-label">Message</label>
                    <input type="text" name="message" value="{{ $filters['message'] ?? '' }}" class="form-control" placeholder="Search in log messages">
                </div>
                <div class="col-12 col-md-3 d-grid">
                    <label class="form-label opacity-0">Search</label>
                    <button class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="card ld-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Logs</h2>
                <span class="text-secondary small">{{ $logs->total() }} entries</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr class="text-secondary">
                            <th>日時</th>
                            <th>システム</th>
                            <th>種別</th>
                            <th>メッセージ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td class="text-nowrap">{{ $log->received_at->format('Y/m/d H:i:s') }}</td>
                                <td>{{ $log->system->name }}</td>
                                <td>
                                    <span class="badge {{ $log->level === 'ERROR' ? 'ld-error' : ($log->level === 'WARN' ? 'ld-warn' : 'ld-info') }}">
                                        {{ $log->level }}
                                    </span>
                                </td>
                                <td>{{ $log->message }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-secondary py-5">ログはまだありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </section>
@endsection
