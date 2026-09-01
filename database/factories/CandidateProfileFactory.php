<?php

namespace Database\Factories;

use App\Models\CandidateProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateProfileFactory extends Factory
{
    protected $model = CandidateProfile::class;

    public function definition(): array
    {
        $skillsList = ['PHP', 'Laravel', 'MySQL', 'JavaScript', 'Vue.js', 'React', 'Python', 'Tailwind CSS', 'Docker', 'REST API', 'Git'];

        return [
            'phone'                    => fake()->phoneNumber(),
            'father_name'              => fake()->name('male'),
            'mother_name'              => fake()->name('female'),
            'dob'                      => fake()->dateTimeBetween('-38 years', '-21 years')->format('Y-m-d'),
            'gender'                   => fake()->randomElement(['male', 'female', 'other']),
            'nationality'              => 'Bangladeshi',
            'present_address'          => fake()->address(),
            'permanent_address'        => fake()->address(),
            'current_title'            => fake()->jobTitle(),
            'job_field'                => fake()->randomElement(['Software Engineering', 'Data Analytics', 'Digital Marketing', 'HR & Admin', 'Finance']),
            'skills'                   => fake()->randomElements($skillsList, rand(3, 6)),
            'experience_years'         => fake()->numberBetween(0, 12),
            'expected_salary'          => fake()->numberBetween(35000, 180000),
            'university_name'          => fake()->company() . ' University',
            'university_degree'        => 'B.Sc. in Computer Science',
            'university_major'         => 'Computer Science',
            'university_cgpa'          => fake()->randomFloat(2, 2.50, 4.00),
            'university_passing_year'  => fake()->numberBetween(2015, 2024),
            'college_name'             => fake()->company() . ' College',
            'college_group'            => 'Science',
            'college_gpa'              => fake()->randomFloat(2, 3.50, 5.00),
            'college_passing_year'     => fake()->numberBetween(2011, 2018),
            'high_school_name'         => fake()->company() . ' High School',
            'high_school_group'        => 'Science',
            'high_school_gpa'          => fake()->randomFloat(2, 3.50, 5.00),
            'high_school_passing_year' => fake()->numberBetween(2009, 2016),
            'cv_path'                  => null,
        ];
    }
}