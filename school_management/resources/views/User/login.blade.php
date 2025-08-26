{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Login - Student Management System')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e7ec 100%);">
    <div class="login-container p-4 bg-white rounded-4 shadow" style="max-width: 420px; width: 100%;">
        <div class="text-center mb-4">
            <h2>Student Management System</h2>
            <p>Sign in to access your account</p>
        </div>

        <form id="login-form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" placeholder="Enter your password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="#" class="text-decoration-none">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
        </form>

        <div class="text-center mt-3">
            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .login-container {
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }
    .btn-login {
        background: #4361ee;
        color: white;
        border-radius: 12px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('login-form').addEventListener('submit', function(e) {
        const submitButton = document.querySelector('.btn-login');
        submitButton.textContent = 'Signing in...';
        submitButton.disabled = true;
    });
</script>
@endpush
