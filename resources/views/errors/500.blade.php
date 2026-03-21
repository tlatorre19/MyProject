@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-1 fw-bold text-danger">500</h1>
    <h2>Server Error</h2>
    <p class="text-muted">Something went wrong. Please try again later.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Go Back Home</a>
</div>
@endsection