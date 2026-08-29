@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header')
    <div class="text-center">
        <h3 class="font-weight-bold text-dark">Hire<span class="text-primary">Metrics</span></h3>
        <p class="login-box-msg p-0 text-muted">Sign in to start your session</p>
    </div>
@endsection

@section('auth_body')
    <form action="{{ route('login') }}" method="post">
        @csrf

        {{-- Email --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="Email Address" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
            @error('email')
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

        {{-- Remember & Submit --}}
        <div class="row align-items-center">
            <div class="col-7">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" id="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="custom-control-label text-sm">Remember Me</label>
                </div>
            </div>
            <div class="col-5">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
        </div>
    </form>
@endsection

@section('auth_footer')
    <p class="my-1 text-center">
        <a href="{{ route('register') }}" class="text-center">Register a new account</a>
    </p>
@endsection