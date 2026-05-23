@extends('admin.layout')
@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold mb-1">Activity Logs</h3>
        <p class="text-muted mb-0" style="font-size:13px;">All reported items activity</p>
    </div>
</div>

<div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr style="background:#f9f9f9;">
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">#</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Item</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Reporter</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Type</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Status</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr style="border-bottom:1px solid #f5f5f5;">
                        <td style="padding:14px 20px; border:none; color:#888;">{{ $loop->iteration }}</td>
                        <td style="padding:14px 20px; border:none;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px; height:36px; border-radius:8px; overflow:hidden; background:#f0f0f0; flex-shrink:0;">
                                    @if($item->photo)
                                        <img src="{{ asset('storage/' . $item->photo) }}"
                                             style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-image text-muted" style="font-size:12px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="fw-bold mb-0" style="font-size:13px;">{{ $item->name }}</p>
                                    <small class="text-muted">{{ $item->category ?? 'No category' }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="padding:14px 20px; border:none; font-size:13px;">{{ $item->reporter_name }}</td>
                        <td style="padding:14px 20px; border:none;">
                            <span class="badge bg-{{ $item->type == 'Lost' ? 'danger' : 'success' }}"
                                  style="font-size:11px; padding:5px 12px; border-radius:20px;">
                                {{ $item->type }}
                            </span>
                        </td>
                        <td style="padding:14px 20px; border:none;">
                            <span class="badge bg-{{ $item->status == 'Pending' ? 'warning' : 'success' }}"
                                  style="font-size:11px; padding:5px 12px; border-radius:20px;">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td style="padding:14px 20px; border:none; font-size:13px; color:#555;">
                            {{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No activity yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection