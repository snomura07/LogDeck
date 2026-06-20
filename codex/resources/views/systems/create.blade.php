@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card ld-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4">
                        <h1 class="h3 mb-1">Register System</h1>
                        <p class="text-secondary mb-0">登録後に専用 API パスが自動発行されます。</p>
                    </div>

                    <form method="post" action="{{ route('systems.store') }}" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label class="form-label">システム名</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">説明</label>
                            <textarea
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button class="btn btn-primary">
                                <i class="bi bi-check2-circle"></i> Register
                            </button>
                            <a href="{{ route('systems.index') }}" class="btn btn-outline-light">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
