@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-white">
            <i class="bi bi-speedometer2 me-2" style="color:#7c6af7"></i>Dashboard
        </h4>
        <small style="color:#6060a0">Welcome back, {{ auth()->user()->name }}!</small>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card p-3 h-100" style="border-left:4px solid #7c6af7">
            <div style="color:#6060a0;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em">Total Users</div>
            <div class="fs-2 fw-bold" style="color:#7c6af7">{{ $totalUsers }}</div>
            <div style="color:#6060a0;font-size:.8rem"><i class="bi bi-people me-1"></i>Registered accounts</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card p-3 h-100" style="border-left:4px solid #4caf82">
            <div style="color:#6060a0;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em">My Games</div>
            <div class="fs-2 fw-bold" style="color:#4caf82">{{ $totalGames }}</div>
            <div style="color:#6060a0;font-size:.8rem"><i class="bi bi-joystick me-1"></i>In your collection</div>
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
            <small style="color:#6060a0" class="mb-3 d-block">Distribution of your collection by genre</small>
            <canvas id="genreChart" height="220"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="fw-semibold text-white mb-1">Games by Status</div>
            <small style="color:#6060a0" class="mb-3 d-block">Track your gaming progress</small>
            <canvas id="statusChart" height="220"></canvas>
        </div>
    </div>
</div>

<!-- Recent Games -->
<div class="card">
    <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom:1px solid #2a2a4a">
        <div class="fw-semibold text-white"><i class="bi bi-clock-history me-2" style="color:#7c6af7"></i>Recent Games</div>
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
                        No games yet. <a href="{{ route('games.create') }}" style="color:#7c6af7">Add your first game!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('scripts')
<script>
const genreData  = @json($genreStats);
const statusData = @json($statusStats);

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
        plugins: { legend: { display: false } },
        scales: {
            y: { ticks: { color: '#6060a0', stepSize: 1 }, grid: { color: '#1e1e3a' } },
            x: { ticks: { color: '#6060a0' }, grid: { display: false } }
        }
    }
});

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Owned', 'Playing', 'Completed', 'Wishlist'],
        datasets: [{
            data: [
                {{ $statusStats->where('status','owned')->first()->count ?? 0 }},
                {{ $statusStats->where('status','playing')->first()->count ?? 0 }},
                {{ $statusStats->where('status','completed')->first()->count ?? 0 }},
                {{ $statusStats->where('status','wishlist')->first()->count ?? 0 }},
            ],
            backgroundColor: ['#4caf82','#4a9af5','#af4af5','#f5a54a'],
            borderColor: '#1a1a2e',
            borderWidth: 3,
        }]
    },
    options: {
        cutout: '65%',
        plugins: {
            legend: {
                labels: { color: '#a0a0c0', padding: 16, usePointStyle: true }
            }
        }
    }
});
</script>
@endsection