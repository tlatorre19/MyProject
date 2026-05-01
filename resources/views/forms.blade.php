@extends('layouts.app')

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
            <form action="{{ route('forms.store') }}" method="POST">
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

                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection