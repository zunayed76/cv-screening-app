@extends('adminlte::page')

{{-- Hide sidebar and adjust content width for guest visitors --}}
@guest
    @push('css')
        <style>
            .main-sidebar, 
            .main-header .nav-link[data-widget="pushmenu"] {
                display: none !important;
            }
            .content-wrapper, 
            .main-footer, 
            .main-header {
                margin-left: 0 !important;
            }
        </style>
    @endpush
@endguest

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>HireMetrics Portal</h1>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    @guest
        {{-- Guest Welcome Banner --}}
        <div class="jumbotron bg-white shadow-sm border">
            <h1 class="display-4 font-weight-bold text-dark">Welcome to Hire<span class="text-primary">Metrics</span></h1>
            <p class="lead">Discover top job opportunities or manage your professional resume with automated screening.</p>
            <hr class="my-4">
            <p>Sign in to build your candidate profile, attach your CV, and start applying.</p>
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Log In</a>
            <a class="btn btn-outline-secondary btn-lg" href="{{ route('register') }}" role="button">Create Account</a>
        </div>
    @endguest

    @auth
        {{-- Logged-In Candidate Dashboard --}}
        {{-- <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Profile</h3>
                        <p>Manage CV & Information</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="{{ route('dashboard') }}" class="small-box-footer">
                        Edit Profile <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div> --}}
    @endauth
</div>
@endsection