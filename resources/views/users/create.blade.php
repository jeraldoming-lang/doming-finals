@extends('layouts.app')
@section('title', 'Add User')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('users.index') }}" class="btn btn-sm"
       style="background:#1a1a2e;color:#a0a0c0;border:1px solid #2a2a4a">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0 text-white">Add New User</h4>
        <small style="color:#6060a0">Create a new account</small>
    </div>
</div>

<div class="card p-4" style="max-width:500px">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Full Name *</label>
            <div class="input-group">
                <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                    <i class="bi bi-person"></i>
                </span>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Juan Dela Cruz">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email Address *</label>
            <div class="input-group">
                <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="user@example.com">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Password *</label>
            <div class="input-group">
                <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 6 characters">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-plus-lg me-1"></i> Create User
            </button>
            <a href="{{ route('users.index') }}" class="btn"
               style="background:#1a1a2e;color:#a0a0c0;border:1px solid #2a2a4a">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection