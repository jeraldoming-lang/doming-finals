@extends('layouts.app')
@section('title', 'Add Game')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('games.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Add New Game</h4>
</div>

<div class="card p-4" style="max-width:640px">
    <form action="{{ route('games.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}" placeholder="e.g. Elden Ring">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Genre *</label>
                <input type="text" name="genre" class="form-control @error('genre') is-invalid @enderror"
                       value="{{ old('genre') }}" placeholder="e.g. RPG, FPS, Strategy">
                @error('genre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Platform *</label>
                <input type="text" name="platform" class="form-control @error('platform') is-invalid @enderror"
                       value="{{ old('platform') }}" placeholder="e.g. PC, PS5, Xbox">
                @error('platform')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Status *</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="owned" {{ old('status')=='owned'?'selected':'' }}>Owned</option>
                    <option value="playing" {{ old('status')=='playing'?'selected':'' }}>Playing</option>
                    <option value="completed" {{ old('status')=='completed'?'selected':'' }}>Completed</option>
                    <option value="wishlist" {{ old('status')=='wishlist'?'selected':'' }}>Wishlist</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Rating (1–10)</label>
                <input type="number" name="rating" class="form-control @error('rating') is-invalid @enderror"
                       min="1" max="10" value="{{ old('rating') }}" placeholder="Optional">
                @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Optional notes...">{{ old('notes') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-plus-lg me-1"></i> Add to Collection
        </button>
    </form>
</div>
@endsection