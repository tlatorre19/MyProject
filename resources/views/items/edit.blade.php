@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Header --}}
        <div class="pt-2 pb-4">
            <h3 class="fw-bold mb-1">Edit Item</h3>
            <h6 class="text-muted">Edit a reported lost and found item</h6>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-round" style="border:none; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

                    {{-- Card Header --}}
                    <div class="card-header border-0 pb-0 pt-4 px-4"
                         style="background:white; border-radius:16px 16px 0 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:46px; height:46px; border-radius:12px;
                                        background:linear-gradient(135deg,#1a4a8a,#2563eb);
                                        display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-edit" style="color:white; font-size:18px;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0" style="color:#1e3a5f;">Edit Reported Item</h5>
                                <small class="text-muted">SNSU Lost & Found System</small>
                            </div>
                        </div>
                        <hr class="mt-3 mb-0">
                    </div>

                    <div class="card-body px-4 pt-3 pb-4">
                        <form action="{{ route('forms.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Item Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-box me-1 text-primary"></i> Item Name
                                </label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ $item->name }}"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-align-left me-1 text-primary"></i> Description
                                </label>
                                <textarea name="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;"
                                    required>{{ $item->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Date Lost/Found --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-calendar me-1 text-primary"></i> Date Lost/Found
                                </label>
                                <input type="date" name="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    value="{{ $item->date }}"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;"
                                    required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Type --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-tag me-1 text-primary"></i> Type
                                </label>
                                <select name="type"
                                    class="form-select @error('type') is-invalid @enderror"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;"
                                    required>
                                    <option value="">Select Type</option>
                                    <option value="Lost" {{ $item->type == 'Lost' ? 'selected' : '' }}>Lost</option>
                                    <option value="Found" {{ $item->type == 'Found' ? 'selected' : '' }}>Found</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-info-circle me-1 text-primary"></i> Status
                                </label>
                                <select name="status"
                                    class="form-select @error('status') is-invalid @enderror"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;"
                                    required>
                                    <option value="Pending" {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Resolved" {{ $item->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Reporter Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-user me-1 text-primary"></i> Reporter Name
                                </label>
                                <input type="text" name="reporter_name"
                                    class="form-control @error('reporter_name') is-invalid @enderror"
                                    value="{{ $item->reporter_name }}"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;"
                                    required>
                                @error('reporter_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Contact No --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-phone me-1 text-primary"></i> Contact No.
                                </label>
                                <input type="text" name="contact_no"
                                    class="form-control @error('contact_no') is-invalid @enderror"
                                    value="{{ $item->contact_no }}"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;"
                                    required>
                                @error('contact_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn fw-bold px-4"
                                        style="background:linear-gradient(135deg,#1a4a8a,#2563eb);
                                               color:white; border-radius:10px; padding:10px 28px;">
                                    <i class="fas fa-save me-2"></i> Update
                                </button>
                                <a href="{{ route('forms') }}" class="btn fw-bold px-4"
                                   style="border:1.5px solid #ccc; border-radius:10px;
                                          padding:10px 28px; color:#666;">
                                    Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection