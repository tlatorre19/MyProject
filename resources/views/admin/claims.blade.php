@extends('layouts.admin')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold mb-1">Claims Management</h3>
        <p class="text-muted mb-0" style="font-size:13px;">Review and approve/reject item claims</p>
    </div>
</div>

<div class="card card-round" style="border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr style="background:#f9f9f9;">
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Item</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Claimed By</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Description</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Proof</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Status</th>
                    <th style="padding:14px 20px; font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:#555; font-weight:600; border:none;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($claims as $claim)
                    <tr style="border-bottom:1px solid #f5f5f5;">

                        {{-- Item --}}
                        <td style="padding:14px 20px; border:none;">
                            <p class="fw-bold mb-0" style="font-size:13px;">{{ $claim->item->name ?? 'N/A' }}</p>
                            <small class="text-muted">{{ $claim->item->type ?? '' }}</small>
                        </td>

                        {{-- Claimed By --}}
                        <td style="padding:14px 20px; border:none;">
                            <p class="fw-bold mb-0" style="font-size:13px;">{{ $claim->user->name ?? 'N/A' }}</p>
                            <small class="text-muted">{{ $claim->user->email ?? '' }}</small>
                        </td>

                        {{-- Description --}}
                        <td style="padding:14px 20px; border:none; font-size:13px; color:#555; max-width:200px;">
                            <p class="mb-1">{{ Str::limit($claim->claim_description, 60) }}</p>
                            @if($claim->color_brand)
                                <small class="text-muted">Color/Brand: {{ $claim->color_brand }}</small>
                            @endif
                        </td>

                        {{-- Proof --}}
                        <td style="padding:14px 20px; border:none;">
                            @if($claim->proof)
                                <a href="{{ asset('storage/' . $claim->proof) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $claim->proof) }}"
                                         style="width:50px; height:50px; object-fit:cover; border-radius:8px; border:1px solid #e0e0e0;">
                                </a>
                            @else
                                <span class="text-muted" style="font-size:12px;">No proof</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td style="padding:14px 20px; border:none;">
                            @php
                                $colors = [
                                    'Pending'  => ['bg' => '#fff8f0', 'text' => '#f39c12'],
                                    'Approved' => ['bg' => '#f0faf5', 'text' => '#2d6a4f'],
                                    'Rejected' => ['bg' => '#fff0f0', 'text' => '#e74c3c'],
                                ];
                                $c = $colors[$claim->status] ?? $colors['Pending'];
                            @endphp
                            <span class="badge"
                                  style="font-size:11px; padding:5px 12px; border-radius:20px;
                                         background:{{ $c['bg'] }}; color:{{ $c['text'] }};">
                                {{ $claim->status }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td style="padding:14px 20px; border:none;">
                            @if($claim->status == 'Pending')
                                <div class="d-flex gap-2">

                                    {{-- Approve --}}
                                    <form action="/admin/claims/{{ $claim->id }}/approve" method="POST" style="display:inline;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-sm fw-bold"
                                                style="background:#f0faf5; color:#2d6a4f; border:1px solid #2d6a4f; border-radius:8px;">
                                            <i class="fas fa-check me-1"></i> Approve
                                        </button>
                                    </form>

                                    {{-- Reject --}}
                                    <form action="/admin/claims/{{ $claim->id }}/reject" method="POST" style="display:inline;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-sm fw-bold"
                                                style="background:#fff0f0; color:#e74c3c; border:1px solid #e74c3c; border-radius:8px;"
                                                onclick="return confirm('Reject this claim?')">
                                            <i class="fas fa-times me-1"></i> Reject
                                        </button>
                                    </form>

                                </div>
                            @else
                                <span class="text-muted" style="font-size:12px;">—</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox mb-3" style="font-size:40px; opacity:0.3; display:block;"></i>
                            No claims submitted yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection