@extends('layouts.dashboard')
@php use Illuminate\Support\Facades\Auth; @endphp
@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Header --}}
        <div class="pt-2 pb-4">
            <h3 class="fw-bold mb-1">Report Lost or Found Item</h3>
            <h6 class="text-muted">Fill in the details below to submit your report</h6>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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
                                <i class="fas fa-pen" style="color:white; font-size:18px;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0" style="color:#1e3a5f;">New Item Report</h5>
                                <small class="text-muted">SNSU Lost & Found System</small>
                            </div>
                        </div>
                        <hr class="mt-3 mb-0">
                    </div>

                    <div class="card-body px-4 pt-3 pb-4">
                        <form action="{{ route('forms.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Item Name + Type --}}
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-semibold text-uppercase"
                                           style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                        <i class="fas fa-tag me-1 text-primary"></i> Item Name
                                    </label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="e.g. Black Umbrella, iPhone 13..."
                                        style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold text-uppercase"
                                           style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                        <i class="fas fa-filter me-1 text-primary"></i> Type
                                    </label>
                                    <select name="type"
                                        class="form-select @error('type') is-invalid @enderror"
                                        style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">
                                        <option value="">Select Type</option>
                                        <option value="Lost" {{ old('type') == 'Lost' ? 'selected' : '' }}>Lost</option>
                                        <option value="Found" {{ old('type') == 'Found' ? 'selected' : '' }}>Found</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Category --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-folder me-1 text-primary"></i> Category
                                </label>
                                <select name="category"
                                    class="form-select @error('category') is-invalid @enderror"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}"
                                            {{ old('category') == $category->name ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-align-left me-1 text-primary"></i> Description
                                </label>
                                <textarea name="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Describe the item's unique features, color, brand, condition, etc."
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Date + Reporter Name --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-uppercase"
                                           style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                        <i class="fas fa-calendar me-1 text-primary"></i> Date Lost/Found
                                    </label>
                                    <input type="date" name="date" value="{{ old('date') }}"
                                        class="form-control @error('date') is-invalid @enderror"
                                        style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-uppercase"
                                           style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                        <i class="fas fa-user me-1 text-primary"></i> Reporter Name
                                    </label>
                                    <input type="text" name="reporter_name" value="{{ old('reporter_name', Auth::user()->name) }}"
                                        class="form-control @error('reporter_name') is-invalid @enderror"
                                        placeholder="Enter your full name"
                                        style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;"
                                        readonly>
                                    @error('reporter_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Contact No --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-phone me-1 text-primary"></i> Contact No.
                                </label>
                                <input type="text" name="contact_no" value="{{ old('contact_no') }}"
                                    class="form-control @error('contact_no') is-invalid @enderror"
                                    placeholder="e.g. 09123456789"
                                    style="border-radius:10px; border:1.5px solid #e0e0e0; padding:10px 14px;">
                                @error('contact_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Photo Upload --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-uppercase"
                                       style="font-size:11px; color:#555; letter-spacing:0.05em;">
                                    <i class="fas fa-image me-1 text-primary"></i>
                                    Upload Photo <span class="fw-normal text-muted">(Optional)</span>
                                </label>

                                <div id="dropZone" style="border: 2px dashed #c0d4f5; border-radius:12px;
                                     padding:2rem; text-align:center; cursor:pointer;
                                     background:#f0f6ff; position:relative; transition: all 0.2s;">

                                    <input type="file" name="photo" id="photoInput" accept="image/*"
                                           style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;">

                                    <div id="uploadPrompt">
                                        <div style="width:56px; height:56px; border-radius:50%;
                                                    background:linear-gradient(135deg,#1a4a8a,#2563eb);
                                                    display:flex; align-items:center; justify-content:center;
                                                    margin:0 auto 0.75rem;">
                                            <i class="fas fa-cloud-upload-alt" style="color:white; font-size:22px;"></i>
                                        </div>
                                        <div style="font-weight:600; color:#1a4a8a; font-size:14px;">
                                            Click or drag and drop image here
                                        </div>
                                        <div style="font-size:12px; color:#888; margin-top:4px;">
                                            Max file size: 5MB
                                        </div>
                                    </div>

                                    <div id="previewBox" style="display:none; margin-top:1rem;">
                                        <img id="previewImg" src="" alt="Preview"
                                             style="max-height:180px; border-radius:10px; border:2px solid #c0d4f5;">
                                        <br>
                                        <button id="removeBtn" type="button"
                                                style="background:none; border:none; color:#c0392b;
                                                       font-size:0.8rem; text-decoration:underline;
                                                       cursor:pointer; margin-top:0.5rem;">
                                            <i class="fas fa-trash me-1"></i> Remove photo
                                        </button>
                                    </div>
                                </div>

                                @error('photo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn fw-bold px-4"
                                        style="background:linear-gradient(135deg,#1a4a8a,#2563eb);
                                               color:white; border-radius:10px; padding:10px 28px;">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Report
                                </button>
                                <a href="{{ route('home') }}" class="btn fw-bold px-4"
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

<script>
const dropZone = document.getElementById('dropZone');
const photoInput = document.getElementById('photoInput');
const previewBox = document.getElementById('previewBox');
const previewImg = document.getElementById('previewImg');
const uploadPrompt = document.getElementById('uploadPrompt');
const removeBtn = document.getElementById('removeBtn');

function showPreview(file) {
    if (!file || !file.type.startsWith('image/')) return;
    if (file.size > 5 * 1024 * 1024) { alert('File too large. Max 5MB.'); return; }
    let reader = new FileReader();
    reader.onload = e => {
        previewImg.src = e.target.result;
        previewBox.style.display = 'block';
        uploadPrompt.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

photoInput.addEventListener('change', e => showPreview(e.target.files[0]));

dropZone.addEventListener('dragover', e => {
    e.preventDefault();
    dropZone.style.borderColor = '#1a4a8a';
    dropZone.style.background = '#e0ecff';
});
dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = '#c0d4f5';
    dropZone.style.background = '#f0f6ff';
});
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.style.borderColor = '#c0d4f5';
    dropZone.style.background = '#f0f6ff';
    showPreview(e.dataTransfer.files[0]);
});

removeBtn.addEventListener('click', e => {
    e.stopPropagation();
    previewImg.src = '';
    previewBox.style.display = 'none';
    uploadPrompt.style.display = 'block';
    photoInput.value = '';
});
</script>

@endsection