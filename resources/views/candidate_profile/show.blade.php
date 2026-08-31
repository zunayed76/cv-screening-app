@extends('adminlte::page')

@section('title', 'Candidate Profile')

@section('content_header')
    <h1>Profile Details</h1>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(!$profile)
        <div class="card text-center p-5">
            <h3>No profile created yet.</h3>
            <div class="mt-3">
                <a href="{{ route('candidate-profile.edit') }}" class="btn btn-primary">Create Profile Now</a>
            </div>
        </div>
    @else
        <div class="row">
            {{-- User Profile Card --}}
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                        <p class="text-muted text-center">{{ $profile->current_title ?? 'N/A' }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ auth()->user()->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b> <a class="float-right">{{ $profile->phone ?? 'N/A' }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Experience</b> <a class="float-right">{{ $profile->experience_years ? $profile->experience_years . ' Years' : 'N/A' }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Expected Salary</b> <a class="float-right">{{ $profile->expected_salary ? number_format($profile->expected_salary) : 'N/A' }}</a>
                            </li>
                        </ul>

                        @if($profile->cv_path)
                            <a href="{{ asset('storage/' . $profile->cv_path) }}" target="_blank" class="btn btn-danger btn-block">
                                <i class="fas fa-file-pdf"></i> Download Attached CV
                            </a>
                        @endif

                        <a href="{{ route('candidate-profile.edit') }}" class="btn btn-primary btn-block mt-2">
                            <i class="fas fa-edit"></i> Edit Details
                        </a>
                    </div>
                </div>
            </div>

            {{-- Main Details --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#overview" data-toggle="tab">Overview</a></li>
                            <li class="nav-item"><a class="nav-link" href="#education" data-toggle="tab">Education</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            {{-- Overview Tab --}}
                            <div class="tab-pane active" id="overview">
                                <strong><i class="fas fa-briefcase mr-1"></i> Job Field</strong>
                                <p class="text-muted">{{ $profile->job_field ?? 'N/A' }}</p>
                                <hr>

                                <strong><i class="fas fa-tools mr-1"></i> Skills</strong>
                                <p class="text-muted">
                                    @if(!empty($profile->skills))
                                        @foreach($profile->skills as $skill)
                                            <span class="badge badge-info">{{ $skill }}</span>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </p>
                                <hr>

                                <strong><i class="fas fa-user mr-1"></i> Personal Details</strong>
                                <div class="row text-muted mt-2">
                                    <div class="col-6"><b>DOB:</b> {{ $profile->dob?->format('d M, Y') ?? 'N/A' }}</div>
                                    <div class="col-6"><b>Gender:</b> {{ ucfirst($profile->gender ?? 'N/A') }}</div>
                                    <div class="col-6"><b>Father:</b> {{ $profile->father_name ?? 'N/A' }}</div>
                                    <div class="col-6"><b>Mother:</b> {{ $profile->mother_name ?? 'N/A' }}</div>
                                    <div class="col-6"><b>Nationality:</b> {{ $profile->nationality ?? 'N/A' }}</div>
                                </div>
                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Addresses</strong>
                                <p class="text-muted">
                                    <b>Present:</b> {{ $profile->present_address ?? 'N/A' }}<br>
                                    <b>Permanent:</b> {{ $profile->permanent_address ?? 'N/A' }}
                                </p>
                            </div>

                            {{-- Education Tab --}}
                            <div class="tab-pane" id="education">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Level</th>
                                            <th>Institute</th>
                                            <th>Degree / Group</th>
                                            <th>CGPA / GPA</th>
                                            <th>Passing Year</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>University</td>
                                            <td>{{ $profile->university_name ?? '-' }}</td>
                                            <td>{{ $profile->university_degree }} {{ $profile->university_major ? '('.$profile->university_major.')' : '' }}</td>
                                            <td>{{ $profile->university_cgpa ?? '-' }}</td>
                                            <td>{{ $profile->university_passing_year ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>College</td>
                                            <td>{{ $profile->college_name ?? '-' }}</td>
                                            <td>{{ $profile->college_group ?? '-' }}</td>
                                            <td>{{ $profile->college_gpa ?? '-' }}</td>
                                            <td>{{ $profile->college_passing_year ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>High School</td>
                                            <td>{{ $profile->high_school_name ?? '-' }}</td>
                                            <td>{{ $profile->high_school_group ?? '-' }}</td>
                                            <td>{{ $profile->high_school_gpa ?? '-' }}</td>
                                            <td>{{ $profile->high_school_passing_year ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@stop