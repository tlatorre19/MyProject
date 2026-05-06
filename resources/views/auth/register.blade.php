@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Role Selector --}}
                        <div class="row mb-4">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('I AM A:') }}</label>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="role-card text-center p-3 border rounded w-50" id="student-card"
                                        onclick="selectRole('student')"
                                        style="cursor:pointer; border: 2px solid #dee2e6;">
                                        <i class="fas fa-user-graduate fa-2x mb-2"></i>
                                        <p class="mb-0 fw-bold">Student</p>
                                    </div>
                                    <div class="role-card text-center p-3 border rounded w-50" id="instructor-card"
                                        onclick="selectRole('instructor')"
                                        style="cursor:pointer; border: 2px solid #dee2e6;">
                                        <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                                        <p class="mb-0 fw-bold">Instructor</p>
                                    </div>
                                </div>
                                <input type="hidden" name="role" id="role" value="{{ old('role', 'student') }}">
                                @error('role')