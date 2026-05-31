@extends('layouts.app')
@section('title', 'Edit User')
@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('users.index') }}" class="btn btn-sm"
        style="background:#1a1a2e;color:#a0a0c0;border:1px solid #2a2a4a">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0 text-white">Edit User</h4>
        <small style="color:#6060a0">Update account information</small>
    </div>
</div>

<div class="card p-4" style="max-width:500px">
    <!-- User info header -->
    <div class="d-flex align-items-center gap-3 mb-4 pb-4" style="border-bottom:1px solid #2a2a4a">
        <div class="rounded-circle d-flex align-items-center justify-content-center"
            style="width:52px;height:52px;min-width:52px;background:#2a2a4a;color:#7c6af7;font-size:1.3rem;font-weight:700">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <div class="fw-semibold text-white">{{ $user->name }}</div>
            <div style="color:#6060a0;font-size:.85rem">{{ $user->email }}</div>
            <div style="color:#6060a0;font-size:.75rem">Member since {{ $user->created_at->format('M d, Y') }}</div>
        </div>
    </div>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Full Name *</label>
            <div class="input-group">
                <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                    <i class="bi bi-person"></i>
                </span>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Email Address *</label>
            <div class="input-group">
                <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-lg me-1"></i> Save Changes
            </button>
            <a href="{{ route('users.index') }}" class="btn"
                style="background:#1a1a2e;color:#a0a0c0;border:1px solid #2a2a4a">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection