@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-1 fw-bold text-danger">403</h1>
    <h2>Access Denied</h2>
    <p class="text-muted">You do not have permission to view this page.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Go Back Home</a>
</div>
@endsection