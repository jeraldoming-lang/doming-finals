@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:#0f0f1a;">
    <div style="width:100%;max-width:440px;padding:1rem;">

        <div class="text-center mb-4">
            <div style="font-size:2.5rem;color:#7c6af7"><i class="bi bi-controller"></i></div>
            <h3 class="fw-bold text-white mt-2">GameCache</h3>
            <p style="color:#6060a0">Create your account</p>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Juan Dela Cruz">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="you@example.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Min. 8 characters">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Repeat password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    <i class="bi bi-person-plus me-2"></i>Create Account
                </button>

                <div class="text-center mt-3" style="color:#6060a0;font-size:.875rem">
                    Already have an account?
                    <a href="{{ route('login') }}" style="color:#7c6af7;text-decoration:none">Sign in here</a>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection