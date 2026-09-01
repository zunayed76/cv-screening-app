@extends('adminlte::page')

@section('title', 'Edit Job')

@section('content_header')
    <h1>Edit Job Opportunity</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Update Job Details</h3>
            </div>
            
            <form action="{{ route('jobs.update', $job->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    
                    <div class="form-group">
                        <label for="title">Job Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $job->title) }}" required>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $job->location) }}" required>
                                @error('location')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Job Type <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="full-time" {{ old('type', $job->type) == 'full-time' ? 'selected' : '' }}>Full-Time</option>
                                    <option value="part-time" {{ old('type', $job->type) == 'part-time' ? 'selected' : '' }}>Part-Time</option>
                                    <option value="contract" {{ old('type', $job->type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="remote" {{ old('type', $job->type) == 'remote' ? 'selected' : '' }}>Remote</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deadline">Application Deadline</label>
                        <input type="date" name="deadline" id="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline', $job->deadline) }}">
                        @error('deadline')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Job Description & Requirements <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ old('description', $job->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop