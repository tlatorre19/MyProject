@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Lost &amp; Found Management System</h2>

    {{-- Alert container – AJAX messages are injected here by ajax-handlers.js --}}
    <div id="ajax-alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- ────────────────────────────────────────────────────────
         REPORT FORM
         id="ajax-create-item-form" → intercepted by ajax-handlers.js
         On success the JS resets this form and appends a new row
         to the table below – no page reload needed.
    ──────────────────────────────────────────────────────────── --}}
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

    {{-- ────────────────────────────────────────────────────────
         ITEMS TABLE
         tbody id="items-table-body" → used by appendItemRow() in
         ajax-handlers.js to inject new rows after AJAX create.
         Delete forms use class "ajax-delete-item".
    ──────────────────────────────────────────────────────────── --}}
    <div class="card">
        <div class="card-header bg-dark text-white">
            Reported Items
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Reporter</th>
                        <th>Contact</th>
                        <th>Match</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="items-table-body">
                    @forelse($items as $item)
                        @php
                            $match = $items
                                ->where('name', $item->name)
                                ->where('type', '!=', $item->type)
                                ->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->date }}</td>
                            <td>
                                <span class="badge bg-{{ $item->type == 'Lost' ? 'danger' : 'success' }}">
                                    {{ $item->type }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'Pending' ? 'warning' : 'success' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>{{ $item->reporter_name }}</td>
                            <td>{{ $item->contact_no }}</td>
                            <td>
                                @if($match)
                                    <span class="badge bg-success">Possible Match</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('forms.edit', $item->id) }}"
                                   class="btn btn-warning btn-sm">Edit</a>

                                {{--
                                    AJAX DELETE: class "ajax-delete-item" is intercepted
                                    in ajax-handlers.js. Row is removed on success.
                                --}}
                                <form action="{{ route('forms.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-inline ajax-delete-item">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="no-items-row">
                            <td colspan="10" class="text-center">No items reported yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/ajax-handlers.js') }}"></script>
@endpush