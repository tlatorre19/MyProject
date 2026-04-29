@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Reported Items</h2>

    <div id="ajax-alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

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