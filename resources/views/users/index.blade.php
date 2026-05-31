@extends('layouts.app')
@section('title', 'Users')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-white">
            <i class="bi bi-people me-2" style="color:var(--purple-light)"></i>Users Management
        </h4>
        <small class="text-secondary">Manage all registered accounts</small>
    </div>
    <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus-fill"></i> Add User
    </button>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card purple">
            <div class="stat-icon" style="background:rgba(124,106,247,.2)">
                <i class="bi bi-people-fill" style="color:#a78bfa"></i>
            </div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value" style="color:#a78bfa">{{ $users->total() }}</div>
            <div class="stat-sub">Registered accounts</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card green">
            <div class="stat-icon" style="background:rgba(34,197,94,.15)">
                <i class="bi bi-person-check-fill" style="color:#4ade80"></i>
            </div>
            <div class="stat-label">Regular Users</div>
            <div class="stat-value" style="color:#4ade80">{{ $users->where('is_admin', false)->count() }}</div>
            <div class="stat-sub">Standard accounts</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card pink">
            <div class="stat-icon" style="background:rgba(168,85,247,.15)">
                <i class="bi bi-shield-check" style="color:#c084fc"></i>
            </div>
            <div class="stat-label">Admins</div>
            <div class="stat-value" style="color:#c084fc">{{ $users->where('is_admin', true)->count() }}</div>
            <div class="stat-sub">Administrator accounts</div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span class="fw-semibold text-white" style="font-size:.9rem">
            <i class="bi bi-list-ul me-2" style="color:var(--purple-light)"></i>All Users
        </span>
        <span class="badge bg-secondary" style="font-size:.75rem">{{ $users->total() }} total</span>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:rgba(255,255,255,.25);font-size:.82rem">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($user->avatar)
                                <img src="{{ asset('avatars/' . $user->avatar) }}"
                                     width="40" height="40"
                                     class="rounded-circle object-fit-cover"
                                     style="border:2px solid rgba(124,106,247,.3)">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                     style="width:40px;height:40px;min-width:40px;background:linear-gradient(135deg,#7c6af7,#a855f7);color:#fff;font-size:.9rem">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-semibold text-white" style="font-size:.88rem">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                    <span style="font-size:.68rem;background:rgba(124,106,247,.2);color:#a78bfa;padding:1px 8px;border-radius:20px">You</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color:rgba(255,255,255,.5);font-size:.875rem">{{ $user->email }}</td>
                    <td>
                        @if($user->is_admin)
                            <span class="d-inline-flex align-items-center gap-1"
                                  style="background:rgba(168,85,247,.15);color:#c084fc;padding:4px 12px;border-radius:20px;font-size:.78rem;font-weight:600;border:1px solid rgba(168,85,247,.2)">
                                <i class="bi bi-shield-check"></i> Admin
                            </span>
                        @else
                            <span class="d-inline-flex align-items-center gap-1"
                                  style="background:rgba(34,197,94,.1);color:#4ade80;padding:4px 12px;border-radius:20px;font-size:.78rem;border:1px solid rgba(34,197,94,.15)">
                                <i class="bi bi-person"></i> User
                            </span>
                        @endif
                    </td>
                    <td style="color:rgba(255,255,255,.35);font-size:.82rem">
                        <i class="bi bi-calendar3 me-1"></i>{{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td>
                        <button class="btn btn-sm edit-btn me-1"
                                style="background:rgba(59,130,246,.15);color:#60a5fa;border:1px solid rgba(59,130,246,.2);border-radius:8px"
                                data-bs-toggle="modal" data-bs-target="#editUserModal"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm"
                                    style="background:rgba(239,68,68,.15);color:#f87171;border:1px solid rgba(239,68,68,.2);border-radius:8px">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:rgba(255,255,255,.2)">
                        <i class="bi bi-people d-block mb-2" style="font-size:2.5rem;opacity:.2"></i>
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-3" style="border-top:1px solid rgba(255,255,255,.05)">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- ── Add User Modal ── -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="modal-icon" style="background:rgba(124,106,247,.2)">
                        <i class="bi bi-person-plus-fill" style="color:#a78bfa"></i>
                    </div>
                    <div>
                        <div class="modal-title text-white">Add New User</div>
                        <div style="font-size:.78rem;color:rgba(255,255,255,.35)">Fill in the account details</div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                    <div class="d-flex align-items-center gap-2 p-3 mb-3 rounded-3"
                         style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2)">
                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                        <span style="font-size:.875rem;color:#fca5a5">{{ $errors->first() }}</span>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="Juan Dela Cruz">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="user@example.com">
                        </div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 6 characters">
                        </div>
                        <div class="form-text">Minimum 6 characters required</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-person-plus me-1"></i> Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ── Edit User Modal ── -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="modal-icon" style="background:rgba(59,130,246,.2)">
                        <i class="bi bi-pencil-square" style="color:#60a5fa"></i>
                    </div>
                    <div>
                        <div class="modal-title text-white">Edit User</div>
                        <div style="font-size:.78rem;color:rgba(255,255,255,.35)">Update account information</div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="editEmail" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4"
                            style="background:rgba(59,130,246,.8);border-color:transparent;border-radius:10px;color:#fff;font-weight:500">
                        <i class="bi bi-check-lg me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
<script>
    new bootstrap.Modal(document.getElementById('addUserModal')).show();
</script>
@endif

@endsection
@section('scripts')
<script>
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editName').value  = this.dataset.name;
            document.getElementById('editEmail').value = this.dataset.email;
            document.getElementById('editUserForm').action = '/users/' + this.dataset.id;
        });
    });
</script>
@endsection