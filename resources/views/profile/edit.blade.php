@extends('layouts.app')
@section('title', 'My Profile')
@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1 text-white">
        <i class="bi bi-person-circle me-2" style="color:var(--purple-light)"></i>My Profile
    </h4>
    <small class="text-secondary">Manage your account information</small>
</div>

<div class="row g-4">

    <!-- Left Column — Avatar Card -->
    <div class="col-md-4">
        <div class="card p-4 text-center h-100">
            <div class="mb-3">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('avatars/' . auth()->user()->avatar) }}"
                         class="rounded-circle mb-3"
                         style="width:100px;height:100px;object-fit:cover;border:3px solid var(--purple);box-shadow:0 0 20px rgba(124,106,247,.4)">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold mx-auto mb-3"
                         style="width:100px;height:100px;background:linear-gradient(135deg,#7c6af7,#a855f7);color:#fff;font-size:2.5rem;box-shadow:0 0 20px rgba(124,106,247,.4)">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif

                <h5 class="fw-bold text-white mb-1">{{ auth()->user()->name }}</h5>
                <div style="color:rgba(255,255,255,.4);font-size:.85rem">{{ auth()->user()->email }}</div>

                <div class="mt-2">
                    @if(auth()->user()->is_admin)
                        <span class="d-inline-flex align-items-center gap-1"
                              style="background:rgba(168,85,247,.15);color:#c084fc;padding:4px 14px;border-radius:20px;font-size:.78rem;font-weight:600;border:1px solid rgba(168,85,247,.2)">
                            <i class="bi bi-shield-check"></i> Administrator
                        </span>
                    @else
                        <span class="d-inline-flex align-items-center gap-1"
                              style="background:rgba(34,197,94,.1);color:#4ade80;padding:4px 14px;border-radius:20px;font-size:.78rem;border:1px solid rgba(34,197,94,.15)">
                            <i class="bi bi-person"></i> Member
                        </span>
                    @endif
                </div>
            </div>

            <hr style="border-color:rgba(255,255,255,.07)">

            <!-- Stats -->
            <div class="row g-2 text-center">
                <div class="col-6">
                    <div style="background:rgba(124,106,247,.1);border-radius:10px;padding:.75rem">
                        <div class="fw-bold text-white" style="font-size:1.3rem">
                            {{ auth()->user()->games()->count() }}
                        </div>
                        <div style="font-size:.72rem;color:rgba(255,255,255,.35)">Total Games</div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:rgba(168,85,247,.1);border-radius:10px;padding:.75rem">
                        <div class="fw-bold text-white" style="font-size:1.3rem">
                            {{ auth()->user()->games()->where('status','completed')->count() }}
                        </div>
                        <div style="font-size:.72rem;color:rgba(255,255,255,.35)">Completed</div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:rgba(59,130,246,.1);border-radius:10px;padding:.75rem">
                        <div class="fw-bold text-white" style="font-size:1.3rem">
                            {{ auth()->user()->games()->where('status','playing')->count() }}
                        </div>
                        <div style="font-size:.72rem;color:rgba(255,255,255,.35)">Playing</div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:rgba(245,158,11,.1);border-radius:10px;padding:.75rem">
                        <div class="fw-bold text-white" style="font-size:1.3rem">
                            {{ auth()->user()->games()->where('status','wishlist')->count() }}
                        </div>
                        <div style="font-size:.72rem;color:rgba(255,255,255,.35)">Wishlist</div>
                    </div>
                </div>
            </div>

            <hr style="border-color:rgba(255,255,255,.07)">

            <div style="font-size:.78rem;color:rgba(255,255,255,.25)">
                <i class="bi bi-calendar3 me-1"></i>
                Member since {{ auth()->user()->created_at->format('F d, Y') }}
            </div>
        </div>
    </div>

    <!-- Right Column — Edit Form -->
    <div class="col-md-8">
        <div class="card p-4">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid rgba(255,255,255,.07)">
                <div style="width:40px;height:40px;background:rgba(124,106,247,.2);border-radius:12px;display:flex;align-items:center;justify-content:center">
                    <i class="bi bi-pencil-square" style="color:#a78bfa"></i>
                </div>
                <div>
                    <div class="fw-semibold text-white">Edit Information</div>
                    <div style="font-size:.78rem;color:rgba(255,255,255,.35)">Update your personal details</div>
                </div>
            </div>

            @if(session('success'))
            <div class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
                 style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.2)">
                <i class="bi bi-check-circle-fill" style="color:#4ade80"></i>
                <span style="font-size:.875rem;color:#4ade80">{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
                 style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2)">
                <i class="bi bi-exclamation-circle-fill text-danger"></i>
                <span style="font-size:.875rem;color:#fca5a5">{{ $errors->first() }}</span>
            </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name *</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', auth()->user()->name) }}"
                               placeholder="Your full name">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address *</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', auth()->user()->email) }}"
                               placeholder="your@email.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Profile Picture</label>
                    <div class="p-3 rounded-3" style="background:rgba(255,255,255,.03);border:1px dashed rgba(255,255,255,.1)">
                        <div class="d-flex align-items-center gap-3">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('avatars/' . auth()->user()->avatar) }}"
                                     class="rounded-circle"
                                     style="width:48px;height:48px;object-fit:cover;border:2px solid var(--purple)">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                     style="width:48px;height:48px;min-width:48px;background:linear-gradient(135deg,#7c6af7,#a855f7);color:#fff;font-size:1.1rem">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <input type="file" name="avatar" id="avatarInput"
                                       class="form-control @error('avatar') is-invalid @enderror"
                                       accept="image/*">
                                <div class="form-text">JPG, PNG, GIF — max 2MB</div>
                                @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-1"></i> Update Profile
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Recent Activity -->
        <div class="card p-4 mt-4">
            <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom:1px solid rgba(255,255,255,.07)">
                <div style="width:40px;height:40px;background:rgba(59,130,246,.2);border-radius:12px;display:flex;align-items:center;justify-content:center">
                    <i class="bi bi-clock-history" style="color:#60a5fa"></i>
                </div>
                <div>
                    <div class="fw-semibold text-white">Recent Games</div>
                    <div style="font-size:.78rem;color:rgba(255,255,255,.35)">Your latest added games</div>
                </div>
            </div>
            @forelse(auth()->user()->games()->latest()->take(4)->get() as $game)
            <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px solid rgba(255,255,255,.04)">
                <div class="rounded-2 d-flex align-items-center justify-content-center"
                     style="width:36px;height:36px;min-width:36px;background:rgba(124,106,247,.15)">
                    <i class="bi bi-joystick" style="color:#a78bfa;font-size:.85rem"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold text-white" style="font-size:.85rem">{{ $game->title }}</div>
                    <div style="font-size:.75rem;color:rgba(255,255,255,.3)">{{ $game->genre }} · {{ $game->platform }}</div>
                </div>
                @php
                    $sc = ['owned'=>['#4ade80','rgba(34,197,94,.15)'],'playing'=>['#60a5fa','rgba(59,130,246,.15)'],'completed'=>['#c084fc','rgba(168,85,247,.15)'],'wishlist'=>['#fbbf24','rgba(245,158,11,.15)']];
                    $c = $sc[$game->status] ?? $sc['owned'];
                @endphp
                <span style="background:{{ $c[1] }};color:{{ $c[0] }};padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:500">
                    {{ ucfirst($game->status) }}
                </span>
            </div>
            @empty
            <div class="text-center py-3" style="color:rgba(255,255,255,.2);font-size:.875rem">
                <i class="bi bi-joystick me-1"></i> No games yet
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection