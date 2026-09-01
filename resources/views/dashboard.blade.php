@extends('adminlte::page')

@guest
    @push('css')
        <style>
            .main-sidebar, .main-header .nav-link[data-widget="pushmenu"] { display: none !important; }
            .content-wrapper, .main-footer, .main-header { margin-left: 0 !important; }
        </style>
    @endpush
@endguest

@section('title', 'Dashboard')

@section('content_header')
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @guest
        <div class="jumbotron bg-white shadow-sm border mb-4">
            <h1 class="display-4 font-weight-bold text-dark">Welcome to Hire<span class="text-primary">Metrics</span></h1>
            <p class="lead">Discover top job opportunities or manage your professional resume with automated screening.</p>
            <hr class="my-4">
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}">Log In</a>
            <a class="btn btn-outline-secondary btn-lg" href="{{ route('register') }}">Create Account</a>
        </div>
    @endguest
    <br>
    <h3 class="h4 font-weight-bold text-dark mb-3">Explore Job Opportunities</h3>

    <div class="row" id="job-container">
        @include('partials.job-cards', ['jobs' => $jobs, 'appliedJobIds' => $appliedJobIds])
    </div>

    <div id="scroll-sentinel" class="text-center py-4" style="{{ $jobs->hasMorePages() ? '' : 'display: none;' }}">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading more jobs...</span>
        </div>
    </div>
</div>

{{-- 1. Guest Login Prompt Modal --}}
<div class="modal fade" id="guestLoginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                <h4 class="font-weight-bold">Login Required</h4>
                <p class="text-muted">You need to sign in as a candidate to submit job applications.</p>
                <div class="mt-4 d-flex justify-content-center gap-2">
                    <a href="{{ route('login') }}" class="btn btn-primary px-4 mr-2">Log In</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary px-4">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. Candidate Application & Profile Preview Modal --}}
@auth
<div class="modal fade" id="applyPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="applyModalJobTitle">Review Application</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            
            <form id="applyJobForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    @if($profile)
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle mr-1"></i> Confirm your candidate profile details below before submitting your application to the employer.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Full Name:</strong> {{ Auth::user()->name }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Email:</strong> {{ Auth::user()->email }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Phone:</strong> {{ $profile->phone ?? 'Not specified' }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Current Title:</strong> {{ $profile->current_title ?? 'N/A' }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Experience:</strong> {{ $profile->experience_years ? $profile->experience_years . ' Years' : 'N/A' }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Education:</strong> {{ $profile->university_degree ?? 'N/A' }}
                            </div>
                        </div>

                        <hr>

                        <div class="form-group mb-0">
                            <label>Attached Resume/CV:</label>
                            <div>
                                @if($profile->cv_path)
                                    <a href="{{ asset('storage/' . $profile->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-file-pdf mr-1"></i> View Attached CV
                                    </a>
                                @else
                                    <span class="text-danger font-weight-bold">No CV Attached!</span>
                                    <p class="small text-muted mb-0">Please upload a CV in your profile before applying.</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="text-danger font-weight-bold mb-1">Your candidate profile is incomplete.</p>
                            <p class="text-muted">Please fill in your profile details and upload your CV first.</p>
                            <a href="{{ route('candidate-profile.show') }}" class="btn btn-warning btn-sm mt-2">
                                <i class="fas fa-user-edit mr-1"></i> Create/Edit Candidate Profile
                            </a>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    @if($profile && $profile->cv_path)
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-1"></i> Confirm & Submit Application
                        </button>
                    @else
                        <a href="{{ route('candidate-profile.show') }}" class="btn btn-primary">Go to Profile</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endauth
@endsection

@push('js')
<script>
    // Delegate event handler for dynamically loaded job card apply buttons
    $(document).on('click', '.btn-open-apply', function() {
        let jobId = $(this).data('job-id');
        let jobTitle = $(this).data('job-title');

        $('#applyModalJobTitle').text('Apply for: ' + jobTitle);
        
        // Dynamic URL generated relative to application root path
        let applyUrl = "{{ url('/jobs') }}/" + jobId + "/apply";
        $('#applyJobForm').attr('action', applyUrl);
        
        $('#applyPreviewModal').modal('show');
    });

    // Infinite Scroll logic
    let page = 1;
    let hasMorePages = {{ $jobs->hasMorePages() ? 'true' : 'false' }};
    let isLoading = false;

    const container = document.getElementById('job-container');
    const sentinel = document.getElementById('scroll-sentinel');

    const loadMoreJobs = () => {
        if (isLoading || !hasMorePages) return;
        isLoading = true;
        page++;

        fetch(`?page=${page}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            if (html.trim() === '') {
                hasMorePages = false;
                sentinel.style.display = 'none';
            } else {
                container.insertAdjacentHTML('beforeend', html);
                isLoading = false;
            }
        })
        .catch(() => { isLoading = false; });
    };

    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && hasMorePages) {
            loadMoreJobs();
        }
    }, { rootMargin: '100px' });

    if (sentinel) observer.observe(sentinel);
</script>
@endpush