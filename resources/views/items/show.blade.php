@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="pt-2 pb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('browse') }}" class="text-primary">Browse Items</a></li>
                <li class="breadcrumb-item active">Item Details</li>
            </ol>
        </nav>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">

            {{-- Left: Image --}}
            <div class="col-md-6 mb-4">
                <div style="border-radius:16px; overflow:hidden; height:550px; background:#f0f0f0;">
                    @if($item->photo)
                        <img src="{{ asset('storage/' . $item->photo) }}"
                             alt="{{ $item->name }}"
                             style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                            <i class="fas fa-image" style="font-size:80px; opacity:0.2;"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right: Details --}}
            <div class="col-md-6">

                {{-- Status + ID + Type --}}
                <div class="d-flex align-items-center gap-2 mb-3" style="flex-wrap:wrap;">
                    <span class="badge bg-{{ $item->status == 'Pending' ? 'warning' : 'success' }}"
                          style="font-size:13px; padding:6px 14px; border-radius:20px;">
                        {{ $item->status }}
                    </span>
                    <span class="text-muted" style="font-size:13px;">
                        ID: #{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                    <span class="badge bg-{{ $item->type == 'Lost' ? 'danger' : 'success' }}"
                          style="font-size:13px; padding:6px 14px; border-radius:20px;">
                        {{ $item->type }}
                    </span>
                </div>

                {{-- Item Name --}}
                <h2 class="fw-bold mb-3" style="color:#1a4a8a;">{{ $item->name }}</h2>

                {{-- Info Card --}}
                <div class="card card-round p-3 mb-3" style="background:#f0f6ff;">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <p class="text-uppercase text-muted mb-1" style="font-size:11px; font-weight:600;">Date Reported</p>
                            <p class="fw-bold mb-0">
                                <i class="fas fa-calendar me-1 text-primary"></i>
                                {{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="text-uppercase text-muted mb-1" style="font-size:11px; font-weight:600;">Contact No.</p>
                            <p class="fw-bold mb-0">
                                <i class="fas fa-phone me-1 text-primary"></i>
                                {{ $item->contact_no }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <p class="fw-bold mb-1" style="color:#1a4a8a;">Description</p>
                    <p class="text-muted">{{ $item->description }}</p>
                </div>

                {{-- Reporter Card --}}
                <div class="card card-round p-3" style="background:linear-gradient(135deg,#1a4a8a,#2563eb); color:white;">
                    <div class="d-flex align-items-center mb-2">
                        <div style="width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,0.2);
                                    display:flex; align-items:center; justify-content:center; margin-right:12px;">
                            <i class="fas fa-user" style="font-size:18px;"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <small style="opacity:0.8; font-size:11px; text-transform:uppercase; letter-spacing:0.05em;">Reported By</small>
                                @if($item->user)
                                    @php
                                        $role = $item->user->role ?? 'User';
                                        $roleColor = match(strtolower($role)) {
                                            'admin'      => '#1a5fa8',
                                            'instructor' => '#1a5fa8',
                                            'student'    => '#b45309',
                                            default      => '#555555',
                                        };
                                    @endphp
                                    <span style="font-size:10px; padding:2px 8px; border-radius:20px;
                                                 background:{{ $roleColor }}; color:white; font-weight:600;">
                                        {{ ucfirst($role) }}
                                    </span>
                                @endif
                            </div>
                            <p class="fw-bold mb-0">{{ $item->reporter_name }}</p>
                        </div>
                    </div>
                    <p style="font-size:13px; opacity:0.9; margin-bottom:12px;">
                        Are you the owner of this item? Submit your proof to claim it back.
                    </p>
                    <button class="btn w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#claimModal"
                            style="background:white; color:#1a4a8a; border-radius:20px;">
                        <i class="fas fa-user-check me-2"></i> Claim This Item
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Claim Modal --}}
<div class="modal fade" id="claimModal" tabindex="-1" aria-labelledby="claimModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; border:none;">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="claimModalLabel">Submit Claim Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-1">
                <p class="text-muted mb-4" style="font-size:13px;">
                    To prevent fake claims, please provide accurate details that only the owner would know.
                </p>

                <form action="{{ route('items.claim', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="text-uppercase fw-bold mb-1" style="font-size:11px; color:#333;">
                            Detailed Description
                        </label>
                        <textarea name="claim_description" class="form-control" rows="3"
                                  placeholder="Describe specific details of the item..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="text-uppercase fw-bold mb-1" style="font-size:11px; color:#333;">
                            Color / Brand
                        </label>
                        <input type="text" name="color_brand" class="form-control"
                               placeholder="e.g. Silver / Apple">
                    </div>

                    <div class="mb-3">
                        <label class="text-uppercase fw-bold mb-1" style="font-size:11px; color:#333;">
                            Unique Marks / Features
                        </label>
                        <textarea name="unique_marks" class="form-control" rows="3"
                                  placeholder="Scratches, specific stickers, contents inside, etc."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="text-uppercase fw-bold mb-1" style="font-size:11px; color:#333;">
                            Upload ID or Proof <span class="fw-normal text-muted">(Optional)</span>
                        </label>
                        <input type="file" name="proof" class="form-control" accept="image/*,.pdf">
                        <small class="text-muted mt-1 d-block">Receipt, photo of you with the item, or Student ID.</small>
                    </div>

                    <button type="submit" class="btn w-100 fw-bold"
                            style="background:linear-gradient(135deg,#1a4a8a,#2563eb); color:white; border-radius:20px; padding:12px;">
                        Submit Proof & Claim
                    </button>

                </form>

                <p class="text-center text-muted mt-3" style="font-size:11px;">
                    <i class="fas fa-shield-alt me-1"></i>
                    Security Notice: All claims are securely stored and verified by admins.
                </p>
            </div>

        </div>
    </div>
</div>

@endsection