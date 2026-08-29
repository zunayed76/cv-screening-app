<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Personal & Contact Info
            $table->string('phone')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();

            // Professional Profile
            $table->string('current_title')->nullable();
            $table->string('job_field')->nullable();
            $table->json('skills')->nullable();
            $table->unsignedTinyInteger('experience_years')->nullable();
            $table->unsignedInteger('expected_salary')->nullable();

            // Higher Education (University)
            $table->string('university_name')->nullable();
            $table->string('university_degree')->nullable();
            $table->string('university_major')->nullable();
            $table->decimal('university_cgpa', 3, 2)->nullable();
            $table->unsignedSmallInteger('university_passing_year')->nullable();

            // Higher Secondary (College)
            $table->string('college_name')->nullable();
            $table->string('college_group')->nullable();
            $table->decimal('college_gpa', 3, 2)->nullable();
            $table->unsignedSmallInteger('college_passing_year')->nullable();

            // Secondary School (High School)
            $table->string('high_school_name')->nullable();
            $table->string('high_school_group')->nullable();
            $table->decimal('high_school_gpa', 3, 2)->nullable();
            $table->unsignedSmallInteger('high_school_passing_year')->nullable();

            // CV Attachment
            $table->string('cv_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
