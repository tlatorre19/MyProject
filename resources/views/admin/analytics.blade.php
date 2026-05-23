@extends('layouts.admin')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold mb-1">Analytics & Statistics 📊</h3>
        <p class="text-muted mb-0" style="font-size:13px;">Visualizing data for community management.</p>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-4">
                <p class="text-uppercase text-muted mb-1" style="font-size:11px; font-weight:600; letter-spacing:0.05em;">Return Rate</p>
                <h2 class="fw-bold mb-0" style="color:#1b4332;">{{ $returnRate }}%</h2>
                <div style="height:4px; background:#e0e0e0; border-radius:4px; margin-top:0.75rem;">
                    <div style="height:4px; background:#2d6a4f; border-radius:4px; width:{{ $returnRate }}%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-4">
                <p class="text-uppercase text-muted mb-1" style="font-size:11px; font-weight:600; letter-spacing:0.05em;">Avg. Recovery</p>
                <h2 class="fw-bold mb-0" style="color:#1b4332;">~{{ $avgRecovery }} Days</h2>
                <p class="text-muted mb-0" style="font-size:12px; margin-top:0.75rem;">Estimated time</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-4">
                <p class="text-uppercase text-muted mb-1" style="font-size:11px; font-weight:600; letter-spacing:0.05em;">Total Activity</p>
                <h2 class="fw-bold mb-0" style="color:#1b4332;">{{ $totalActivity }}</h2>
                <p class="text-muted mb-0" style="font-size:12px; margin-top:0.75rem;">Records in system</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-4">
                <p class="text-uppercase text-muted mb-1" style="font-size:11px; font-weight:600; letter-spacing:0.05em;">Success Stories</p>
                <h2 class="fw-bold mb-0" style="color:#f39c12;">{{ $successStories }}</h2>
                <p class="text-muted mb-0" style="font-size:12px; margin-top:0.75rem;">Items returned</p>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row 1 --}}
<div class="row g-3 mb-4">
    {{-- Line Chart --}}
    <div class="col-md-8">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-calendar me-2 text-success"></i> Peak Months of Lost Items
                </h6>
                <canvas id="lineChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Donut Chart --}}
    <div class="col-md-4">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-balance-scale me-2 text-success"></i> Lost vs Found Ratio
                </h6>
                <canvas id="donutChart" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row 2 --}}
<div class="row g-3">
    {{-- Bar Chart --}}
    <div class="col-md-8">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-tags me-2 text-success"></i> Most Lost Item Categories
                </h6>
                <canvas id="barChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Pie Chart --}}
    <div class="col-md-4">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-check-double me-2 text-success"></i> Items Returned vs Unclaimed
                </h6>
                <canvas id="pieChart" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Line Chart - Peak Months
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthLabels) !!},
            datasets: [{
                label: 'Lost Items',
                data: {!! json_encode($monthData) !!},
                borderColor: '#2d6a4f',
                backgroundColor: 'rgba(45,106,79,0.1)',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: '#2d6a4f',
                pointRadius: 5,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Donut Chart - Lost vs Found
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Lost', 'Found'],
            datasets: [{
                data: [{{ $totalLost }}, {{ $totalFound }}],
                backgroundColor: ['#e74c3c', '#2d6a4f'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 12 } }
                }
            },
            cutout: '65%',
        }
    });

    // Bar Chart - Categories
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                label: 'Items',
                data: {!! json_encode($categoryData) !!},
                backgroundColor: '#2d6a4f',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Pie Chart - Returned vs Unclaimed
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Returned', 'Active'],
            datasets: [{
                data: [{{ $returned }}, {{ $active }}],
                backgroundColor: ['#2d6a4f', '#d4c97a'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 12 } }
                }
            }
        }
    });
</script>

@endsection