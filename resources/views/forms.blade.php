@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Lost & Found Management System</h2>

    <div id="ajax-alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Report Lost or Found Item
        </div>
        <div class="card-body">
            <form id="ajax-create-item-form"
                  action="{{ route('forms.store') }}"
                  method="POST">
                @csrf

                <div class="mb-3">
                    <label>Item Name</label>
                    <input type="text" name="name" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label>Date Lost/Found</label>
                    <input type="date" name="date" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-select">
                        <option value="">Select Type</option>
                        <option value="Lost">Lost</option>
                        <option value="Found">Found</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label>Reporter Name</label>
                    <input type="text" name="reporter_name" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label>Contact No.</label>
                    <input type="text" name="contact_no" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .is-invalid {
        border-color: #dc3545 !important;
        background-color: #fff8f8 !important;
    }
    .is-invalid:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
    }
    .invalid-feedback {
        display: none;
        color: #dc3545;
        font-size: 0.875em;
    }
    .is-invalid ~ .invalid-feedback {
        display: block;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/ajax-handlers.js') }}"></script>
@endpush