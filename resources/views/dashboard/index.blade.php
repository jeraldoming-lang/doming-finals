@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-white">
            <i class="bi bi-speedometer2 me-2" style="color:#7c6af7"></i>Dashboard
        </h4>
        <small style="color:#6060a0">
            Welcome back, {{ auth()->user()->name }}!
            {{ $isAdmin ? 'Viewing total platform data.' : 'Viewing your personal collection.' }}
        </small>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card p-3 h-100" style="border-left:4px solid #4caf82">
            <div style="color:#6060a0;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em">
                {{ $isAdmin ? 'Total Games' : 'My Games' }}
            </div>
            <div class="fs-2 fw-bold" style="color:#4caf82">{{ $totalGames }}</div>
            <div style="color:#6060a0;font-size:.8rem">
                <i class="bi bi-joystick me-1"></i>{{ $isAdmin ? 'Across all users' : 'In your collection' }}
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card p-3 h-100" style="border-left:4px solid #4a9af5">
            <div style="color:#6060a0;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em">Playing</div>
            <div class="fs-2 fw-bold" style="color:#4a9af5">{{ $statusStats->where('status','playing')->first()->count ?? 0 }}</div>
            <div style="color:#6060a0;font-size:.8rem"><i class="bi bi-play-circle me-1"></i>Currently playing</div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card p-3 h-100" style="border-left:4px solid #7c6af7">
            @if($isAdmin)
                <div style="color:#6060a0;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em">Total Users</div>
                <div class="fs-2 fw-bold" style="color:#7c6af7">{{ $totalUsers }}</div>
                <div style="color:#6060a0;font-size:.8rem"><i class="bi bi-people me-1"></i>Registered accounts</div>
            @else
                <div style="color:#6060a0;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em">Wishlist</div>
                <div class="fs-2 fw-bold" style="color:#7c6af7">{{ $statusStats->where('status','wishlist')->first()->count ?? 0 }}</div>
                <div style="color:#6060a0;font-size:.8rem"><i class="bi bi-bookmark-heart me-1"></i>Saved for later</div>
            @endif
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="card p-3 h-100" style="border-left:4px solid #af4af5">
            <div style="color:#6060a0;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em">Completed</div>
            <div class="fs-2 fw-bold" style="color:#af4af5">{{ $statusStats->where('status','completed')->first()->count ?? 0 }}</div>
            <div style="color:#6060a0;font-size:.8rem"><i class="bi bi-trophy me-1"></i>Finished games</div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="fw-semibold text-white mb-1">Games by Genre</div>
            <small style="color:#6060a0" class="mb-3 d-block">
                {{ $isAdmin ? 'Distribution across all users by genre' : 'Distribution of your collection by genre' }}
            </small>
            <div style="height:220px">
                <canvas id="genreChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="fw-semibold text-white mb-1">Games by Status</div>
            <small style="color:#6060a0" class="mb-3 d-block">
                {{ $isAdmin ? 'Overall gaming progress across all users' : 'Track your gaming progress' }}
            </small>
            <div style="height:220px">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Games -->
<div class="card">
    <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom:1px solid #2a2a4a">
        <div class="fw-semibold text-white">
            <i class="bi bi-clock-history me-2" style="color:#7c6af7"></i>Recent Games
        </div>
        <a href="{{ route('games.index') }}" class="btn btn-sm btn-primary">View All</a>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Platform</th>
                    <th>Status</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentGames as $game)
                <tr>
                    <td class="fw-semibold text-white">{{ $game->title }}</td>
                    <td><span class="badge" style="background:#2a2a4a;color:#a0a0c0">{{ $game->genre }}</span></td>
                    <td style="color:#a0a0c0">{{ $game->platform }}</td>
                    <td>
                        @php
                        $colors = ['owned'=>'#4caf82','playing'=>'#4a9af5','completed'=>'#af4af5','wishlist'=>'#f5a54a'];
                        $bgs = ['owned'=>'#2a4a3a','playing'=>'#2a3a4a','completed'=>'#3a2a4a','wishlist'=>'#4a3a2a'];
                        @endphp
                        <span class="badge" style="background:{{ $bgs[$game->status] ?? '#2a2a4a' }};color:{{ $colors[$game->status] ?? '#a0a0c0' }}">
                            {{ ucfirst($game->status) }}
                        </span>
                    </td>
                    <td>
                        @if($game->rating)
                        <span style="color:#f5a54a">
                            @for($i=1;$i<=5;$i++)
                                <i class="bi bi-star{{ $i <= round($game->rating/2) ? '-fill' : '' }}" style="font-size:.7rem"></i>
                                @endfor
                        </span>
                        <small style="color:#6060a0"> {{ $game->rating }}/10</small>
                        @else
                        <span style="color:#6060a0">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="color:#6060a0">
                        <i class="bi bi-joystick d-block mb-2" style="font-size:2rem;color:#2a2a4a"></i>
                        No games yet.
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addGameModal" style="color:#7c6af7">
                            Add your first game!
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Game Modal -->
<div class="modal fade" id="addGameModal" tabindex="-1" aria-labelledby="addGameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background:#111124;border:1px solid #2a2a4a;color:#fff;border-radius:16px">
            <div class="modal-header" style="border-bottom:1px solid #2a2a4a">
                <h5 class="modal-title fw-bold" id="addGameModalLabel">
                    <i class="bi bi-plus-circle me-2" style="color:#7c6af7"></i>Add New Game
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Elden Ring" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Genre *</label>
                            <input type="text" name="genre" class="form-control" placeholder="e.g. RPG, FPS, Strategy" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Platform *</label>
                            <input type="text" name="platform" class="form-control" placeholder="e.g. PC, PS5, Xbox" required>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select" required>
                                <option value="owned">Owned</option>
                                <option value="playing">Playing</option>
                                <option value="completed">Completed</option>
                                <option value="wishlist">Wishlist</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Rating (1–10)</label>
                            <input type="number" name="rating" class="form-control" min="1" max="10" placeholder="Optional">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Game Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Optional notes..."></textarea>
                    </div>
                </div>

                <div class="modal-footer" style="border-top:1px solid #2a2a4a">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Add to Collection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@section('scripts')
<script>
    const genreData = @json($genreStats);

    const statusData = [
        {{ $statusStats->where('status', 'owned')->first()->count ?? 0 }},
        {{ $statusStats->where('status', 'playing')->first()->count ?? 0 }},
        {{ $statusStats->where('status', 'completed')->first()->count ?? 0 }},
        {{ $statusStats->where('status', 'wishlist')->first()->count ?? 0 }}
    ];

    Chart.defaults.color = '#6060a0';
    Chart.defaults.borderColor = '#2a2a4a';

    new Chart(document.getElementById('genreChart'), {
        type: 'bar',
        data: {
            labels: genreData.map(d => d.genre),
            datasets: [{
                label: 'Games',
                data: genreData.map(d => d.count),
                backgroundColor: '#7c6af7',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#6060a0',
                        stepSize: 1
                    },
                    grid: { color: '#1e1e3a' }
                },
                x: {
                    ticks: { color: '#6060a0' },
                    grid: { display: false }
                }
            }
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Owned', 'Playing', 'Completed', 'Wishlist'],
            datasets: [{
                data: statusData,
                backgroundColor: ['#4caf82', '#4a9af5', '#af4af5', '#f5a54a'],
                borderColor: '#1a1a2e',
                borderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    labels: {
                        color: '#a0a0c0',
                        padding: 16,
                        usePointStyle: true
                    }
                }
            }
        }
    });
</script>
@endsection