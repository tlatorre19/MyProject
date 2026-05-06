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
                            <label class="col-md-4 col-form-label text-md-end fw-bold">I AM A:</label>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="role-card text-center p-3 border rounded w-50"
                                        id="student-card"
                                        onclick="selectRole('student')"
                                        style="cursor:pointer;">
                                        <i class="fas fa-user-graduate fa-2x mb-2"></i>
                                        <p class="mb-0 fw-bold">Student</p>
                                    </div>
                                    <div class="role-card text-center p-3 border rounded w-50"
                                        id="instructor-card"
                                        onclick="selectRole('instructor')"
                                        style="cursor:pointer;">
                                        <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                                        <p class="mb-0 fw-bold">Instructor</p>
                                    </div>
                                </div>
                                <input type="hidden" name="role" id="role" value="student">
                                @if($errors->has('role'))
                                    <span class="text-danger"><strong>{{ $errors->first('role') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        {{-- Full Name --}}
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Full Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Student ID (only shown for students) --}}
                        <div class="row mb-3" id="student-id-field" style="display:none;">
                            <label for="student_id" class="col-md-4 col-form-label text-md-end">{{ __('Student ID') }}</label>
                            <div class="col-md-6">
                                <input id="student_id" type="text"
                                    class="form-control @error('student_id') is-invalid @enderror"
                                    name="student_id" value="{{ old('student_id') }}"
                                    placeholder="e.g. 1234567">
                                @error('student_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Instructor ID (only shown for instructors) --}}
                        <div class="row mb-3" id="instructor-id-field" style="display:none;">
                            <label for="instructor_id" class="col-md-4 col-form-label text-md-end">{{ __('Instructor ID') }}</label>
                            <div class="col-md-6">
                                <input id="instructor_id" type="text"
                                    class="form-control"
                                    name="student_id" 
                                    value="{{ old('student_id') }}"
                                    placeholder="e.g. INST-001">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password"
                                    class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Register Now') }}
                                </button>
                            </div>
                        </div>

                        {{-- Login link --}}
                        <div class="row mt-3">
                            <div class="col-md-6 offset-md-4 text-center">
                                <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .role-card {
        border: 2px solid #dee2e6 !important;
        transition: all 0.2s;
    }
    .role-card:hover {
        border-color: #0d6efd !important;
        background-color: #f0f7ff;
    }
    .role-card.selected {
        border-color: #0d6efd !important;
        background-color: #e7f1ff;
        color: #0d6efd;
    }
</style>

<script>
    function selectRole(role) {
        // Set hidden input value
        document.getElementById('role').value = role;

        // Reset both cards
        document.getElementById('student-card').classList.remove('selected');
        document.getElementById('instructor-card').classList.remove('selected');

        // Highlight selected card
        document.getElementById(role + '-card').classList.add('selected');

        // Show/hide fields based on role
        if (role === 'student') {
            document.getElementById('student-id-field').style.display = 'flex';
            document.getElementById('instructor-id-field').style.display = 'none';
            document.getElementById('instructor_id').value = '';
        } else {
            document.getElementById('student-id-field').style.display = 'none';
            document.getElementById('instructor-id-field').style.display = 'flex';
            document.getElementById('student_id').value = '';
        }
    }

    // Set default on page load
    window.onload = function() {
        selectRole('student');
    };
</script>
@endsection