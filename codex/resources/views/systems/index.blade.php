@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Systems</h1>
            <p class="text-secondary mb-0">送信元システムの登録と API パス管理</p>
        </div>
        <a href="{{ route('systems.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add System
        </a>
    </div>

    <section class="card ld-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr class="text-secondary">
                            <th>システム名</th>
                            <th>説明</th>
                            <th>API パス</th>
                            <th>登録日時</th>
                            <th class="text-end">総ログ件数</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($systems as $system)
                            <tr>
                                <td class="fw-semibold">{{ $system->name }}</td>
                                <td>{{ $system->description ?: 'なし' }}</td>
                                <td><code>/api/logs/{{ $system->api_path }}</code></td>
                                <td>{{ $system->created_at->format('Y/m/d H:i') }}</td>
                                <td class="text-end">{{ $system->logs_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">登録済みシステムはありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $systems->links() }}
            </div>
        </div>
    </section>
@endsection
