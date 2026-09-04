@extends('adminlte::page')

@section('title', 'Manage Jobs')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Manage Posted Jobs</h1>
        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle mr-1"></i> Post New Job
        </a>
    </div>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card card-outline card-primary">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Deadline</th>
                    <th>Posted Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.show', $job->id) }}" class="text-dark font-weight-bold">
                                {{ $job->title }}
                            </a>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst($job->type) }}</span>
                        </td>
                        <td>{{ $job->location }}</td>
                        <td>{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('M d, Y') : 'N/A' }}</td>
                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                        <td class="text-right">
                            <!-- AI Candidate Ranking Button -->
                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-primary mr-1" title="View Candidates & AI Scores">
                                <i class="fas fa-brain"></i>
                                Candidates
                                <span class="badge badge-light ml-1">{{ $job->applications_count ?? $job->applications->count() }}</span>
                            </a>

                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-warning mr-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job posting?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No job postings found. Click "Post New Job" to get started.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($jobs->hasPages())
        <div class="card-footer clearfix">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
@stop