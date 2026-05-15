@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Lost & Found Management System</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Report Lost or Found Item
        </div>
        <div class="card-body">
            <form action="{{ route('forms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Item Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter item name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Enter at least 10 characters">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Date Lost/Found</label>
                    <input type="date" name="date" value="{{ old('date') }}"
                        class="form-control @error('date') is-invalid @enderror">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="">Select Type</option>
                        <option value="Lost" {{ old('type') == 'Lost' ? 'selected' : '' }}>Lost</option>
                        <option value="Found" {{ old('type') == 'Found' ? 'selected' : '' }}>Found</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Reporter Name</label>
                    <input type="text" name="reporter_name" value="{{ old('reporter_name') }}"
                        class="form-control @error('reporter_name') is-invalid @enderror"
                        placeholder="Enter your full name">
                    @error('reporter_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Contact No.</label>
                    <input type="text" name="contact_no" value="{{ old('contact_no') }}"
                        class="form-control @error('contact_no') is-invalid @enderror"
                        placeholder="Enter contact number">
                    @error('contact_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Photo Upload --}}
                <div class="mb-3">
                    <label class="fw-semibold text-muted small text-uppercase">
                        Upload Photo <span class="fw-normal">(Optional)</span>
                    </label>

                    <div id="dropZone" style="border: 2px dashed #ccc; border-radius: 8px; padding: 2rem;
                         text-align: center; cursor: pointer; background: #f9f9f9; position: relative;">

                        <input type="file" name="photo" id="photoInput" accept="image/*"
                               style="position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;">

                        <div id="uploadPrompt">
                            <div style="font-size:2.5rem; color:#f0a500;">&#9729;&#65039;</div>
                            <div style="font-weight:600; color:#333;">Click or drag and drop image here</div>
                            <div style="font-size:0.8rem; color:#888;">Max file size: 5MB</div>
                        </div>

                        <div id="previewBox" style="display:none; margin-top:1rem;">
                            <img id="previewImg" src="" alt="Preview"
                                 style="max-height:180px; border-radius:8px; border:1px solid #ddd;">
                            <br>
                            <button id="removeBtn" type="button"
                                    style="background:none; border:none; color:#c0392b; font-size:0.8rem;
                                           text-decoration:underline; cursor:pointer; margin-top:0.5rem;">
                                Remove photo
                            </button>
                        </div>
                    </div>

                    @error('photo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
            </form>
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
    dropZone.style.borderColor = '#0d6efd';
    dropZone.style.background = '#e8f0fe';
});
dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = '#ccc';
    dropZone.style.background = '#f9f9f9';
});
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.style.borderColor = '#ccc';
    dropZone.style.background = '#f9f9f9';
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