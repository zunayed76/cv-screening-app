<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|max:20',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'nationality' => 'required|string|max:100',
            'present_address' => 'required|string',
            'permanent_address' => 'required|string',
            'expected_salary' => 'required|numeric|min:0',

            // Kept nullable as requested
            'current_title' => 'nullable|string|max:255',
            'job_field' => 'nullable|string|max:255',
            'skills' => 'nullable|array',
            'experience_years' => 'nullable|numeric|min:0',

            // University
            'university_name' => 'required|string|max:255',
            'university_degree' => 'required|string|max:255',
            'university_major' => 'required|string|max:255',
            'university_cgpa' => 'required|numeric|between:0,5.00',
            'university_passing_year' => 'required|digits:4|integer',

            // College (HSC)
            'college_name' => 'required|string|max:255',
            'college_group' => 'required|string|max:100',
            'college_gpa' => 'required|numeric|between:0,5.00',
            'college_passing_year' => 'required|digits:4|integer',

            // High School (SSC)
            'high_school_name' => 'required|string|max:255',
            'high_school_group' => 'required|string|max:100',
            'high_school_gpa' => 'required|numeric|between:0,5.00',
            'high_school_passing_year' => 'required|digits:4|integer',

            // File upload (made required, but optional on update if CV already exists)
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
        ];
    }
    protected function prepareForValidation(): void
    {
        if ($this->has('skills') && is_string($this->skills)) {
            $skillsArray = array_filter(
                array_map('trim', explode(',', $this->skills))
            );

            $this->merge([
                'skills' => $skillsArray,
            ]);
        }
    }
}