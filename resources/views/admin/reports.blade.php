@extends('layouts.admin')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold mb-1">System Logs & Reports</h3>
        <p class="text-muted mb-0" style="font-size:13px;">Analytics and activity overview of SNSU.</p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()"
                class="btn fw-bold"
                style="background:#2d6a4f; color:white; border-radius:10px; padding:8px 20px; font-size:13px;">
            <i class="fas fa-print me-2"></i> Print
        </button>
    </div>
</div>

{{-- Filters --}}
<div class="card card-round mb-4" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
    <div class="card-body px-4 py-3">
        <form method="GET" action="{{ route('admin.reports') }}">
            <div class="row align-items-end g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-uppercase"
                           style="font-size:11px; color:#555; letter-spacing:0.05em;">
                        Item Status
                    </label>
                    <select name="status" class="form-select"
                            style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-uppercase"
                           style="font-size:11px; color:#555; letter-spacing:0.05em;">
                        Report Type
                    </label>
                    <select name="type" class="form-select"
                            style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">
                        <option value="">All Report Types</option>
                        <option value="Lost" {{ request('type') == 'Lost' ? 'selected' : '' }}>Lost</option>
                        <option value="Found" {{ request('type') == 'Found' ? 'selected' : '' }}>Found</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn w-100 fw-bold"
                            style="background:linear-gradient(135deg,#2d6a4f,#40916c);
                                   color:white; border-radius:10px; padding:10px;">
                        Apply Analytics Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Reports Table --}}
<div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
    <div class="card-body p-0">
        <table class="table mb-0" id="reportsTable">
            <thead>
                <tr style="background:#f9f9f9;">
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Tracking ID</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Item Description</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Category</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Reported By</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Logging Date</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Current Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr style="border-bottom:1px solid #f5f5f5;">
                        <td style="padding:14px 20px; border:none; font-size:13px; color:#888; font-weight:600;">
                            #{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="padding:14px 20px; border:none;">
                            <p class="fw-bold mb-0" style="font-size:13px;">{{ $item->name }}</p>
                            <small class="text-muted">{{ $item->type }}</small>
                        </td>
                        <td style="padding:14px 20px; border:none; font-size:13px; color:#555;">
                            {{ $item->category ?? 'N/A' }}
                        </td>
                        <td style="padding:14px 20px; border:none; font-size:13px; color:#555;">
                            {{ $item->reporter_name }}
                        </td>
                        <td style="padding:14px 20px; border:none; font-size:13px; color:#555;">
                            {{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}
                        </td>
                        <td style="padding:14px 20px; border:none;">
                            @php
                                $statusColors = [
                                    'Pending'  => ['bg' => '#fff8f0', 'text' => '#f39c12'],
                                    'Resolved' => ['bg' => '#f0faf5', 'text' => '#2d6a4f'],
                                ];
                                $sc = $statusColors[$item->status] ?? $statusColors['Pending'];
                            @endphp
                            <span class="badge"
                                  style="font-size:11px; padding:5px 12px; border-radius:20px;
                                         background:{{ $sc['bg'] }}; color:{{ $sc['text'] }}; font-weight:600;">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-file-alt mb-3" style="font-size:40px; opacity:0.3; display:block;"></i>
                            No reports found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection