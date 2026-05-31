@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:#0f0f1a;">
    <div style="width:100%;max-width:420px;padding:1rem;">

        <div class="text-center mb-4">
            <div style="font-size:2.5rem;color:#7c6af7"><i class="bi bi-controller"></i></div>
            <h3 class="fw-bold text-white mt-2">GameCache</h3>
            <p style="color:#6060a0">Sign in to your collection</p>
        </div>

        <div class="card p-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if($errors->any())
                <div class="alert alert-danger py-2 mb-3" style="background:#3a1a1a;border-color:#f54a4a;color:#f54a4a;font-size:.875rem">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="you@example.com" autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:#16213e;border-color:#2a2a4a;color:#6060a0">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember" style="color:#a0a0c0;font-size:.875rem">
                            Remember me
                        </label>
                    </div>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color:#7c6af7;font-size:.875rem;text-decoration:none">
                        Forgot password?
                    </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>

                <div class="text-center mt-3" style="color:#6060a0;font-size:.875rem">
                    No account yet?
                    <a href="{{ route('register') }}" style="color:#7c6af7;text-decoration:none">Register here</a>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection