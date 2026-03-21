@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-1 fw-bold text-danger">404</h1>
    <h2>Page Not Found</h2>
    <p class="text-muted">The page you are looking for does not exist.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Go Back Home</a>
</div>
@endsection