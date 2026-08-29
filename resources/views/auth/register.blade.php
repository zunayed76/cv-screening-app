@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('auth_header')
    <div class="text-center">
        <h3 class="font-weight-bold text-dark">Hire<span class="text-primary">Metrics</span></h3>
        <p class="login-box-msg p-0 text-muted">Create a new membership</p>
    </div>
@endsection

@section('auth_body')
    <form action="{{ route('register') }}" method="post">
        @csrf

        {{-- Name --}}
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="Full Name" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
            @error('name')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        {{-- Email --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="Email Address" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        {{-- Role Selection --}}
        <div class="input-group mb-3">
            <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Register as...</option>
                <option value="candidate" {{ old('role') == 'candidate' ? 'selected' : '' }}>Candidate</option>
                <option value="company" {{ old('role') == 'company' ? 'selected' : '' }}>Company / Recruiter</option>
            </select>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-users-cog"></span></div>
            </div>
            @error('role')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        {{-- Password --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                   placeholder="Retype Password" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
            @error('password_confirmation')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
@endsection

@section('auth_footer')
    <p class="my-1 text-center">
        <a href="{{ route('login') }}" class="text-center">I already have an account</a>
    </p>
@endsection