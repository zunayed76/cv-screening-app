@extends('adminlte::page')

@section('title', 'Company Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Company Dashboard</h1>
        <span class="text-muted"><i class="far fa-calendar-alt"></i> {{ now()->format('l, F j, Y') }}</span>
    </div>
@stop

@section('content')
<div class="container-fluid">
    {{-- Metric Cards (Small Boxes) --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_candidates'] }}</h3>
                    <p>Total Candidates</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['active_jobs'] ?? 0 }}</h3>
                    <p>Active Job Posts</p>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <a href="{{ route('jobs.index') }}" class="small-box-footer">
                    Manage Jobs <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['total_applications'] }}</h3>
                    <p>Job Applications</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="#" class="small-box-footer">Review Applications <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div> --}}

    <div class="row">
        {{-- Recent Candidate Profiles Table --}}
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-tie mr-1"></i> Recently Joined Candidates</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-valign-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Candidate</th>
                                    <th>Title</th>
                                    <th>Degree</th>
                                    <th>Expected Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCandidates as $candidate)
                                    <tr>
                                        <td>
                                            <strong>{{ $candidate->user->name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $candidate->phone }}</small>
                                        </td>
                                        <td>{{ $candidate->current_title ?? 'N/A' }}</td>
                                        <td>{{ $candidate->university_degree ?? 'N/A' }}</td>
                                        <td>
                                            @if($candidate->expected_salary)
                                                ${{ number_format($candidate->expected_salary) }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($candidate->cv_path)
                                                <a href="{{ asset('storage/' . $candidate->cv_path) }}" target="_blank" class="btn btn-xs btn-danger" title="Download CV">
                                                    <i class="fas fa-file-pdf"></i> CV
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No candidate profiles registered yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions & System Info Panel --}}
        <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-rocket mr-1"></i> Quick Actions</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('jobs.create') }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-plus-circle mr-1"></i> Post New Job Opportunity
                    </a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-cog mr-1"></i> Company Settings
                    </a>
                </div>
            </div>

            {{-- <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Status Overview</h3>
                </div>
                <div class="card-body p-3">
                    <div class="info-box bg-light mb-2">
                        <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Unread Messages</span>
                            <span class="info-box-number">5</span>
                        </div>
                    </div>
                    <div class="info-box bg-light mb-0">
                        <span class="info-box-icon bg-success"><i class="far fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Approved Listings</span>
                            <span class="info-box-number">{{ $stats['active_jobs'] }}</span>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@stop