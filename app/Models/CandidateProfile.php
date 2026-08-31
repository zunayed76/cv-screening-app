<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'father_name',
        'mother_name',
        'dob',
        'gender',
        'nationality',
        'present_address',
        'permanent_address',
        'current_title',
        'job_field',
        'skills',
        'experience_years',
        'expected_salary',
        'university_name',
        'university_degree',
        'university_major',
        'university_cgpa',
        'university_passing_year',
        'college_name',
        'college_group',
        'college_gpa',
        'college_passing_year',
        'high_school_name',
        'high_school_group',
        'high_school_gpa',
        'high_school_passing_year',
        'cv_path',
    ];

    protected $casts = [
        'skills' => 'array',
        'dob' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}