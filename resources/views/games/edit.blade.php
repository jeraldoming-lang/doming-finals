@extends('layouts.app')
@section('title', 'Edit Game')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('games.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="fw-bold mb-0">Edit Game</h4>
</div>

<div class="card p-4" style="max-width:640px">
    <form action="{{ route('games.update', $game) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $game->title) }}">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Genre *</label>
                <input type="text" name="genre" class="form-control" value="{{ old('genre', $game->genre) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Platform *</label>
                <input type="text" name="platform" class="form-control" value="{{ old('platform', $game->platform) }}">
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Status *</label>
                <select name="status" class="form-select">
                    @foreach(['owned','playing','completed','wishlist'] as $s)
                        <option value="{{ $s }}" {{ old('status',$game->status)==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Rating (1–10)</label>
                <input type="number" name="rating" class="form-control" min="1" max="10"
                       value="{{ old('rating', $game->rating) }}">
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $game->notes) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-check-lg me-1"></i> Save Changes
        </button>
    </form>
</div>
@endsection