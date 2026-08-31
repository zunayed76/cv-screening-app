@extends('adminlte::page')

@section('title', 'Edit Candidate Details')

@section('content_header')
    <h1>Edit Candidate Details</h1>
@stop

@section('content')
<div class="container-fluid">
    {{-- <div class="alert alert-info alert-dismissible fade show mb-3">
        <i class="icon fas fa-info-circle"></i>
        Account information (Name, Email, Password) is managed separately under your <a href="{{ route('profile.show') ?? '#' }}" class="alert-link">Account Settings</a>.
    </div> --}}

    <form action="{{ route('candidate-profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Personal Details --}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Personal Details</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="phone">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $profile->phone) }}">
                        @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="father_name">Father's Name <span class="text-danger">*</span></label>
                        <input type="text" name="father_name" id="father_name" class="form-control @error('father_name') is-invalid @enderror" value="{{ old('father_name', $profile->father_name) }}">
                        @error('father_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="mother_name">Mother's Name <span class="text-danger">*</span></label>
                        <input type="text" name="mother_name" id="mother_name" class="form-control @error('mother_name') is-invalid @enderror" value="{{ old('mother_name', $profile->mother_name) }}">
                        @error('mother_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" name="dob" id="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob', $profile->dob?->format('Y-m-d')) }}">
                        @error('dob')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="gender">Gender <span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $profile->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $profile->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="nationality">Nationality <span class="text-danger">*</span></label>
                        <input type="text" name="nationality" id="nationality" class="form-control @error('nationality') is-invalid @enderror" value="{{ old('nationality', $profile->nationality) }}">
                        @error('nationality')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="present_address">Present Address <span class="text-danger">*</span></label>
                        <textarea name="present_address" id="present_address" class="form-control @error('present_address') is-invalid @enderror" rows="2">{{ old('present_address', $profile->present_address) }}</textarea>
                        @error('present_address')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="permanent_address">Permanent Address <span class="text-danger">*</span></label>
                        <textarea name="permanent_address" id="permanent_address" class="form-control @error('permanent_address') is-invalid @enderror" rows="2">{{ old('permanent_address', $profile->permanent_address) }}</textarea>
                        @error('permanent_address')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Professional Experience --}}
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Professional Overview</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="current_title">Current Title <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="current_title" id="current_title" class="form-control @error('current_title') is-invalid @enderror" value="{{ old('current_title', $profile->current_title) }}" placeholder="e.g. Software Engineer">
                        @error('current_title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="job_field">Job Field <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="job_field" id="job_field" class="form-control @error('job_field') is-invalid @enderror" value="{{ old('job_field', $profile->job_field) }}">
                        @error('job_field')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="experience_years">Experience (Years) <small class="text-muted">(Optional)</small></label>
                        <input type="number" step="0.5" name="experience_years" id="experience_years" class="form-control @error('experience_years') is-invalid @enderror" value="{{ old('experience_years', $profile->experience_years) }}">
                        @error('experience_years')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="expected_salary">Expected Salary <span class="text-danger">*</span></label>
                        <input type="number" name="expected_salary" id="expected_salary" class="form-control @error('expected_salary') is-invalid @enderror" value="{{ old('expected_salary', $profile->expected_salary) }}">
                        @error('expected_salary')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="skills">Skills <small class="text-muted">(Optional, comma-separated)</small></label>
                        <input type="text" name="skills" id="skills" class="form-control @error('skills') is-invalid @enderror" value="{{ old('skills', is_array($profile->skills) ? implode(', ', $profile->skills) : $profile->skills) }}" placeholder="PHP, Laravel, MySQL">
                        @error('skills')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="cv">Upload CV / Resume <span class="text-danger">*</span> <small class="text-muted">(PDF, DOC, DOCX - Max 5MB)</small></label>
                        <div class="custom-file">
                            <input type="file" name="cv" class="custom-file-input @error('cv') is-invalid @enderror" id="cv">
                            <label class="custom-file-label" for="cv">Choose file</label>
                            @error('cv')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                        </div>
                        @if($profile->cv_path)
                            <small class="form-text text-muted">Current file: <a href="{{ asset('storage/' . $profile->cv_path) }}" target="_blank">View File</a></small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Educational Background --}}
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Educational Background</h3>
            </div>
            <div class="card-body">
                <h5 class="text-primary font-weight-bold">University Level</h5>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label>University Name <span class="text-danger">*</span></label>
                        <input type="text" name="university_name" class="form-control @error('university_name') is-invalid @enderror" value="{{ old('university_name', $profile->university_name) }}">
                        @error('university_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Degree <span class="text-danger">*</span></label>
                        <input type="text" name="university_degree" class="form-control @error('university_degree') is-invalid @enderror" value="{{ old('university_degree', $profile->university_degree) }}" placeholder="B.Sc, BBA, etc.">
                        @error('university_degree')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Major <span class="text-danger">*</span></label>
                        <input type="text" name="university_major" class="form-control @error('university_major') is-invalid @enderror" value="{{ old('university_major', $profile->university_major) }}">
                        @error('university_major')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label>CGPA <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="university_cgpa" class="form-control @error('university_cgpa') is-invalid @enderror" value="{{ old('university_cgpa', $profile->university_cgpa) }}">
                        @error('university_cgpa')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Passing Year <span class="text-danger">*</span></label>
                        <input type="number" name="university_passing_year" class="form-control @error('university_passing_year') is-invalid @enderror" value="{{ old('university_passing_year', $profile->university_passing_year) }}">
                        @error('university_passing_year')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <hr>
                <h5 class="text-primary font-weight-bold">College Level (HSC / Equivalent)</h5>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>College Name <span class="text-danger">*</span></label>
                        <input type="text" name="college_name" class="form-control @error('college_name') is-invalid @enderror" value="{{ old('college_name', $profile->college_name) }}">
                        @error('college_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Group / Stream <span class="text-danger">*</span></label>
                        <input type="text" name="college_group" class="form-control @error('college_group') is-invalid @enderror" value="{{ old('college_group', $profile->college_group) }}" placeholder="Science, Commerce, Arts">
                        @error('college_group')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label>GPA <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="college_gpa" class="form-control @error('college_gpa') is-invalid @enderror" value="{{ old('college_gpa', $profile->college_gpa) }}">
                        @error('college_gpa')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Passing Year <span class="text-danger">*</span></label>
                        <input type="number" name="college_passing_year" class="form-control @error('college_passing_year') is-invalid @enderror" value="{{ old('college_passing_year', $profile->college_passing_year) }}">
                        @error('college_passing_year')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <hr>
                <h5 class="text-primary font-weight-bold">High School Level (SSC / Equivalent)</h5>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>High School Name <span class="text-danger">*</span></label>
                        <input type="text" name="high_school_name" class="form-control @error('high_school_name') is-invalid @enderror" value="{{ old('high_school_name', $profile->high_school_name) }}">
                        @error('high_school_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Group / Stream <span class="text-danger">*</span></label>
                        <input type="text" name="high_school_group" class="form-control @error('high_school_group') is-invalid @enderror" value="{{ old('high_school_group', $profile->high_school_group) }}">
                        @error('high_school_group')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-2 form-group">
                        <label>GPA <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="high_school_gpa" class="form-control @error('high_school_gpa') is-invalid @enderror" value="{{ old('high_school_gpa', $profile->high_school_gpa) }}">
                        @error('high_school_gpa')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Passing Year <span class="text-danger">*</span></label>
                        <input type="number" name="high_school_passing_year" class="form-control @error('high_school_passing_year') is-invalid @enderror" value="{{ old('high_school_passing_year', $profile->high_school_passing_year) }}">
                        @error('high_school_passing_year')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Details</button>
                <a href="{{ route('candidate-profile.show') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@stop