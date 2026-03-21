@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Categories</h2>

    {{-- Alert container – AJAX success/error messages are injected here --}}
    <div id="ajax-alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <a href="{{ route('category.create') }}" class="btn btn-primary mb-3">Add Category</a>

    <div class="card">
        <div class="card-header bg-dark text-white">
            Category List
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <a href="{{ route('category.edit', $category->id) }}"
                                   class="btn btn-warning btn-sm">Edit</a>

                                {{--
                                    AJAX DELETE:
                                    Class "ajax-delete-category" is intercepted in ajax-handlers.js.
                                    The JS submits the form via $.ajax and removes the row on success
                                    – no page reload needed.
                                --}}
                                <form action="{{ route('category.destroy', $category->id) }}"
                                      method="POST"
                                      class="d-inline ajax-delete-category">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No categories yet.</td>
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