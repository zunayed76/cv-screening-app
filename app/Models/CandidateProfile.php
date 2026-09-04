<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Smalot\PdfParser\Parser;

class CandidateProfile extends Model
{
    use HasFactory;
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
    /**
     * Parse stored PDF and return raw extracted text for Python API
     */
    public function getCvTextAttribute(): string
    {
        $fullPath = storage_path('app/public/' . $this->cv_path);

        if ($this->cv_path && file_exists($fullPath)) {
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($fullPath);
                return trim(preg_replace('/\s+/', ' ', $pdf->getText()));
            } catch (\Exception $e) {
                // Fallback text if file reading fails
            }
        }

        $skillsText = is_array($this->skills) ? implode(', ', $this->skills) : $this->skills;
        return "Title: {$this->current_title}. Field: {$this->job_field}. Skills: {$skillsText}. Experience: {$this->experience_years} years.";
    }
}