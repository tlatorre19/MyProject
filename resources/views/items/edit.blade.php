@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Item</h2>

    <div class="card">
        <div class="card-header bg-primary text-white">
            Edit Reported Item
        </div>
        <div class="card-body">
            <form action="{{ route('forms.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Item Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ $item->name }}" required>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" required>{{ $item->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Date Lost/Found</label>
                    <input type="date" name="date" class="form-control"
                           value="{{ $item->date }}" required>
                </div>

                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-select" required>
                        <option value="">Select Type</option>
                        <option value="Lost" {{ $item->type == 'Lost' ? 'selected' : '' }}>Lost</option>
                        <option value="Found" {{ $item->type == 'Found' ? 'selected' : '' }}>Found</option>
                    </select>
                </div>

                <div class="mb-3">  {{-- ✅ added --}}
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Pending" {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Resolved" {{ $item->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Reporter Name</label>
                    <input type="text" name="reporter_name" class="form-control"
                           value="{{ $item->reporter_name }}" required>
                </div>

                <div class="mb-3">
                    <label>Contact No.</label>
                    <input type="text" name="contact_no" class="form-control"
                           value="{{ $item->contact_no }}" required>
                </div>

                <a href="{{ route('forms') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection