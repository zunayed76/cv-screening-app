@extends('adminlte::page') <!-- Replace with your AdminLTE base layout -->

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Job Details & Candidate Rankings</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('jobs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Jobs
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Job Meta Box -->
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">{{ $job->title }}</h3>
                <div class="card-tools">
                    <span class="badge badge-info">{{ ucfirst($job->type) }}</span>
                    <span class="badge badge-secondary">{{ $job->location }}</span>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Deadline:</strong> {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('M d, Y') : 'N/A' }}</p>
                <p><strong>Job Description:</strong></p>
                <div class="p-3 bg-light rounded">{{ $job->description }}</div>
            </div>
        </div>

        <!-- Candidate Scores Table -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-brain mr-1"></i> AI Screened Candidates ({{ $applications->count() }})
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Candidate Name</th>
                                <th>Email</th>
                                <th style="width: 25%;">AI Embedding Match</th>
                                <th style="width: 20%;">Keyword Match</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $index => $app)
                                @php
                                    $embScore = round(($app->embedding_score ?? 0) * 100);
                                    $keyScore = round(($app->keyword_score ?? 0) * 100);
                                    
                                    $badgeClass = $embScore >= 75 ? 'bg-success' : ($embScore >= 50 ? 'bg-warning' : 'bg-danger');
                                @endphp
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>{{ $app->candidate->name ?? 'N/A' }}</td>
                                    <td>{{ $app->candidate->email ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="font-weight-bold mr-2">{{ $embScore }}%</span>
                                            <div class="progress flex-grow-1" style="height: 10px;">
                                                <div class="progress-bar {{ $badgeClass }}" role="progressbar" style="width: {{ $embScore }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="font-weight-bold mr-2">{{ $keyScore }}%</span>
                                            <div class="progress flex-grow-1" style="height: 10px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $keyScore }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border">{{ ucfirst($app->status) }}</span>
                                    </td>
                                    <td class="text-right">
                                        @if(optional($app->candidate->candidateProfile)->cv_path)
                                            <a href="{{ asset('storage/' . $app->candidate->candidateProfile->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf"></i> View CV
                                            </a>
                                        @else
                                            <span class="text-muted small">No CV</span>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No candidates have applied to this job yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection