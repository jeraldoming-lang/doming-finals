@extends('layouts.app')
@section('title', 'My Collection')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-white">
            <i class="bi bi-joystick me-2" style="color:var(--purple-light)"></i>My Game Collection
        </h4>
        <small class="text-secondary">Manage your personal game library</small>
    </div>
    <button class="btn btn-primary d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#addGameModal">
        <i class="bi bi-plus-lg"></i> Add Game
    </button>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card purple">
            <div class="stat-icon" style="background:rgba(124,106,247,.2)">
                <i class="bi bi-collection-fill" style="color:#a78bfa"></i>
            </div>
            <div class="stat-label">Total Games</div>
            <div class="stat-value" style="color:#a78bfa">{{ $games->total() }}</div>
            <div class="stat-sub">In your collection</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card blue">
            <div class="stat-icon" style="background:rgba(59,130,246,.15)">
                <i class="bi bi-play-circle-fill" style="color:#60a5fa"></i>
            </div>
            <div class="stat-label">Playing</div>
            <div class="stat-value" style="color:#60a5fa">{{ $games->where('status','playing')->count() }}</div>
            <div class="stat-sub">Currently playing</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card pink">
            <div class="stat-icon" style="background:rgba(168,85,247,.15)">
                <i class="bi bi-trophy-fill" style="color:#c084fc"></i>
            </div>
            <div class="stat-label">Completed</div>
            <div class="stat-value" style="color:#c084fc">{{ $games->where('status','completed')->count() }}</div>
            <div class="stat-sub">Finished games</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card green">
            <div class="stat-icon" style="background:rgba(34,197,94,.15)">
                <i class="bi bi-bookmark-heart-fill" style="color:#4ade80"></i>
            </div>
            <div class="stat-label">Wishlist</div>
            <div class="stat-value" style="color:#4ade80">{{ $games->where('status','wishlist')->count() }}</div>
            <div class="stat-sub">Want to play</div>
        </div>
    </div>
</div>

<!-- Game Cards Grid -->
@if($games->count() > 0)
<div class="row g-3 mb-3">
    @foreach($games as $game)
    @php
        $statusConfig = [
            'owned'     => ['bg'=>'rgba(34,197,94,.15)',  'color'=>'#4ade80', 'icon'=>'bi-check-circle-fill'],
            'playing'   => ['bg'=>'rgba(59,130,246,.15)', 'color'=>'#60a5fa', 'icon'=>'bi-play-circle-fill'],
            'completed' => ['bg'=>'rgba(168,85,247,.15)', 'color'=>'#c084fc', 'icon'=>'bi-trophy-fill'],
            'wishlist'  => ['bg'=>'rgba(245,158,11,.15)', 'color'=>'#fbbf24', 'icon'=>'bi-bookmark-heart-fill'],
        ];
        $s = $statusConfig[$game->status] ?? $statusConfig['owned'];
    @endphp
    <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card h-100 game-card" style="overflow:hidden;transition:transform .2s,box-shadow .2s;cursor:default">

            <!-- Game Image -->
<div style="position:relative;height:200px;overflow:hidden;background:linear-gradient(135deg,#1a1a3a,#2a1a4a)">
    @if($game->image)
        <img src="{{ asset('game-images/' . $game->image) }}"
             style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block">
    @else
        <div class="d-flex align-items-center justify-content-center h-100">
            <i class="bi bi-joystick" style="font-size:3rem;color:rgba(124,106,247,.3)"></i>
        </div>
    @endif

                <!-- Status Badge overlay -->
                <div style="position:absolute;top:10px;left:10px">
                    <span class="d-inline-flex align-items-center gap-1"
                          style="background:rgba(0,0,0,.6);backdrop-filter:blur(8px);color:{{ $s['color'] }};padding:4px 10px;border-radius:20px;font-size:.72rem;font-weight:600;border:1px solid {{ $s['color'] }}40">
                        <i class="bi {{ $s['icon'] }}" style="font-size:.65rem"></i>
                        {{ ucfirst($game->status) }}
                    </span>
                </div>

                <!-- Rating overlay -->
                @if($game->rating)
                <div style="position:absolute;top:10px;right:10px">
                    <span style="background:rgba(0,0,0,.6);backdrop-filter:blur(8px);color:#fbbf24;padding:4px 10px;border-radius:20px;font-size:.72rem;font-weight:600">
                        <i class="bi bi-star-fill me-1" style="font-size:.6rem"></i>{{ $game->rating }}/10
                    </span>
                </div>
                @endif

                <!-- Action buttons overlay -->
                <div class="game-actions"
                     style="position:absolute;bottom:10px;right:10px;display:flex;gap:6px;opacity:0;transition:opacity .2s">
                    <button class="btn btn-sm edit-game-btn"
                            style="background:rgba(59,130,246,.8);color:#fff;border:none;border-radius:8px;width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center"
                            data-bs-toggle="modal" data-bs-target="#editGameModal"
                            data-id="{{ $game->id }}"
                            data-title="{{ $game->title }}"
                            data-genre="{{ $game->genre }}"
                            data-platform="{{ $game->platform }}"
                            data-status="{{ $game->status }}"
                            data-rating="{{ $game->rating }}"
                            data-notes="{{ $game->notes }}">
                        <i class="bi bi-pencil-fill" style="font-size:.75rem"></i>
                    </button>
                    <form action="{{ route('games.destroy', $game) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Remove {{ addslashes($game->title) }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm"
                                style="background:rgba(239,68,68,.8);color:#fff;border:none;border-radius:8px;width:32px;height:32px;padding:0;display:flex;align-items:center;justify-content:center">
                            <i class="bi bi-trash-fill" style="font-size:.75rem"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-3">
                <h6 class="fw-bold text-white mb-1" style="font-size:.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                    {{ $game->title }}
                </h6>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="background:rgba(255,255,255,.07);color:rgba(255,255,255,.5);padding:2px 8px;border-radius:20px;font-size:.72rem">
                        {{ $game->genre }}
                    </span>
                    <span style="color:rgba(255,255,255,.3);font-size:.75rem">
                        <i class="bi bi-display me-1" style="font-size:.65rem"></i>{{ $game->platform }}
                    </span>
                </div>
                @if($game->notes)
                <p style="font-size:.78rem;color:rgba(255,255,255,.3);margin:0;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">
                    {{ $game->notes }}
                </p>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@else
<!-- Empty State -->
<div class="card p-5 text-center">
    <i class="bi bi-joystick d-block mb-3" style="font-size:3.5rem;color:rgba(124,106,247,.3)"></i>
    <h5 class="text-white mb-2">No games yet</h5>
    <p style="color:rgba(255,255,255,.3)">Start building your collection!</p>
    <div>
        <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addGameModal">
            <i class="bi bi-plus-lg me-1"></i> Add Your First Game
        </button>
    </div>
</div>
@endif

<!-- Pagination -->
@if($games->hasPages())
<div class="mt-3">{{ $games->links() }}</div>
@endif

<!-- ── Add Game Modal ── -->
<div class="modal fade" id="addGameModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="modal-icon" style="background:rgba(124,106,247,.2)">
                        <i class="bi bi-plus-circle-fill" style="color:#a78bfa"></i>
                    </div>
                    <div>
                        <div class="modal-title text-white">Add New Game</div>
                        <div style="font-size:.78rem;color:rgba(255,255,255,.35)">Add a game to your collection</div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                    <div class="d-flex align-items-center gap-2 p-3 mb-3 rounded-3"
                         style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2)">
                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                        <span style="font-size:.875rem;color:#fca5a5">{{ $errors->first() }}</span>
                    </div>
                    @endif
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Game Title *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-joystick"></i></span>
                                <input type="text" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" placeholder="e.g. Elden Ring">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Genre *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <input type="text" name="genre"
                                       class="form-control @error('genre') is-invalid @enderror"
                                       value="{{ old('genre') }}" placeholder="e.g. RPG, FPS">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Platform *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-display"></i></span>
                                <input type="text" name="platform"
                                       class="form-control @error('platform') is-invalid @enderror"
                                       value="{{ old('platform') }}" placeholder="e.g. PC, PS5, Xbox">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select">
                                <option value="owned"     {{ old('status')=='owned'     ?'selected':'' }}>Owned</option>
                                <option value="playing"   {{ old('status')=='playing'   ?'selected':'' }}>Playing</option>
                                <option value="completed" {{ old('status')=='completed' ?'selected':'' }}>Completed</option>
                                <option value="wishlist"  {{ old('status')=='wishlist'  ?'selected':'' }}>Wishlist</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rating (1–10)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-star"></i></span>
                                <input type="number" name="rating"
                                       class="form-control"
                                       min="1" max="10" value="{{ old('rating') }}" placeholder="Optional">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Game Cover Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*"
                                   onchange="previewImage(this, 'addPreview')">
                            <div class="form-text">JPG, PNG, GIF — max 2MB</div>
                            <img id="addPreview" src="" alt=""
                                 style="display:none;width:100%;max-height:150px;object-fit:cover;border-radius:10px;margin-top:8px">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2"
                                      placeholder="Optional notes...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-plus-lg me-1"></i> Add to Collection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ── Edit Game Modal ── -->
<div class="modal fade" id="editGameModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="modal-icon" style="background:rgba(59,130,246,.2)">
                        <i class="bi bi-pencil-square" style="color:#60a5fa"></i>
                    </div>
                    <div>
                        <div class="modal-title text-white">Edit Game</div>
                        <div style="font-size:.78rem;color:rgba(255,255,255,.35)">Update game details</div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <form id="editGameForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Game Title *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-joystick"></i></span>
                                <input type="text" name="title" id="editGameTitle" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Genre *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <input type="text" name="genre" id="editGameGenre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Platform *</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-display"></i></span>
                                <input type="text" name="platform" id="editGamePlatform" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status *</label>
                            <select name="status" id="editGameStatus" class="form-select">
                                <option value="owned">Owned</option>
                                <option value="playing">Playing</option>
                                <option value="completed">Completed</option>
                                <option value="wishlist">Wishlist</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rating (1–10)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-star"></i></span>
                                <input type="number" name="rating" id="editGameRating"
                                       class="form-control" min="1" max="10" placeholder="Optional">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Game Cover Image</label>
                            <div id="editCurrentImage" class="mb-2" style="display:none">
                                <img id="editImagePreview" src="" alt="Current"
                                     style="width:100%;max-height:130px;object-fit:cover;border-radius:10px;opacity:.8">
                                <div class="form-text">Current image — upload new to replace</div>
                            </div>
                            <input type="file" name="image" class="form-control" accept="image/*"
                                   onchange="previewImage(this, 'editNewPreview')">
                            <img id="editNewPreview" src="" alt=""
                                 style="display:none;width:100%;max-height:130px;object-fit:cover;border-radius:10px;margin-top:8px">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" id="editGameNotes" class="form-control" rows="2"></textarea>
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

@endsection
@section('scripts')
<style>
    .game-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,.4);
    }
    .game-card:hover .game-actions {
        opacity: 1 !important;
    }
</style>
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    @if($errors->any())
        new bootstrap.Modal(document.getElementById('addGameModal')).show();
    @endif

    document.querySelectorAll('.edit-game-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editGameTitle').value    = this.dataset.title;
            document.getElementById('editGameGenre').value    = this.dataset.genre;
            document.getElementById('editGamePlatform').value = this.dataset.platform;
            document.getElementById('editGameStatus').value   = this.dataset.status;
            document.getElementById('editGameRating').value   = this.dataset.rating || '';
            document.getElementById('editGameNotes').value    = this.dataset.notes || '';
            document.getElementById('editGameForm').action    = '/games/' + this.dataset.id;

            // Show current image if exists
            const imgData = this.dataset.image;
            const currentImg = document.getElementById('editCurrentImage');
            const imgPreview = document.getElementById('editImagePreview');
            if (imgData) {
                imgPreview.src = '/game-images/' + imgData;
                currentImg.style.display = 'block';
            } else {
                currentImg.style.display = 'none';
            }

            // Reset new preview
            document.getElementById('editNewPreview').style.display = 'none';
        });
    });
</script>
@endsection