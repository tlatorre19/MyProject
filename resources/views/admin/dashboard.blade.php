@extends('admin.layout')

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold mb-1">Operational Overview</h3>
        <p class="text-muted mb-0" style="font-size:13px;">Real-time statistics of SNSU Lost and Found System</p>
    </div>
    <div style="background:white; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:600; color:#555; border:1px solid #e0e0e0;">
        <i class="fas fa-calendar me-2 text-success"></i>{{ now()->format('M d, Y') }}
    </div>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:46px; height:46px; border-radius:12px; background:#fff0f0;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-search" style="color:#e74c3c; font-size:18px;"></i>
                    </div>
                    <div>
                        <span class="badge mb-1" style="background:#fff0f0; color:#e74c3c; font-size:10px;">LOST</span>
                        <p class="text-muted mb-0" style="font-size:11px;">Total Reports</p>
                        <h4 class="fw-bold mb-0">{{ $totalLost }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:46px; height:46px; border-radius:12px; background:#f0faf5;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-hands-helping" style="color:#2d6a4f; font-size:18px;"></i>
                    </div>
                    <div>
                        <span class="badge mb-1" style="background:#f0faf5; color:#2d6a4f; font-size:10px;">FOUND</span>
                        <p class="text-muted mb-0" style="font-size:11px;">Total Recovered</p>
                        <h4 class="fw-bold mb-0">{{ $totalFound }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:46px; height:46px; border-radius:12px; background:#f0f8ff;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-check-circle" style="color:#2980b9; font-size:18px;"></i>
                    </div>
                    <div>
                        <span class="badge mb-1" style="background:#f0f8ff; color:#2980b9; font-size:10px;">CLAIMED</span>
                        <p class="text-muted mb-0" style="font-size:11px;">Successfully Returned</p>
                        <h4 class="fw-bold mb-0">{{ $totalClaimed }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:46px; height:46px; border-radius:12px; background:#fff8f0;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-clock" style="color:#f39c12; font-size:18px;"></i>
                    </div>
                    <div>
                        <span class="badge mb-1" style="background:#fff8f0; color:#f39c12; font-size:10px;">PENDING</span>
                        <p class="text-muted mb-0" style="font-size:11px;">Awaiting Review</p>
                        <h4 class="fw-bold mb-0">{{ $totalPending }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Items Table --}}
<div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">System Log & Recent Reports</h5>
        <a href="{{ route('admin.items') }}"
           class="btn btn-sm fw-bold"
           style="border:1.5px solid #2d6a4f; color:#2d6a4f; border-radius:20px; padding:5px 16px;">
            View All Items
        </a>
    </div>
    <div class="card-body p-0 mt-3">
        <table class="table mb-0">
            <thead>
                <tr style="background:#f9f9f9;">
                    <th style="padding:12px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Item Details</th>
                    <th style="padding:12px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Reporter</th>
                    <th style="padding:12px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Status</th>
                    <th style="padding:12px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentItems as $item)
                    <tr style="border-bottom:1px solid #f5f5f5;">
                        <td style="padding:14px 20px; border:none;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:44px; height:44px; border-radius:10px; overflow:hidden; background:#f0f0f0; flex-shrink:0;">
                                    @if($item->photo)
                                        <img src="{{ asset('storage/' . $item->photo) }}"
                                             style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-image text-muted" style="font-size:16px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="fw-bold mb-0" style="font-size:14px;">{{ $item->name }}</p>
                                    <small class="text-muted">{{ $item->category ?? 'No category' }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="padding:14px 20px; border:none;">
                            <p class="fw-bold mb-0" style="font-size:13px;">{{ $item->reporter_name }}</p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</small>
                        </td>
                        <td style="padding:14px 20px; border:none;">
                            <span class="badge bg-{{ $item->status == 'Pending' ? 'warning' : 'success' }}"
                                  style="font-size:11px; padding:5px 12px; border-radius:20px;">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td style="padding:14px 20px; border:none;">
                            <a href="{{ route('forms.edit', $item->id) }}"
                               style="color:#2d6a4f; font-size:13px; text-decoration:none;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">No items yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection