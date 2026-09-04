<?php

namespace Database\Factories;

use App\Models\CandidateProfile;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class CandidateProfileFactory extends Factory
{
    protected $model = CandidateProfile::class;

    public function definition(): array
    {
        $csSkills = ['PHP', 'Laravel', 'MySQL', 'Python', 'FastAPI', 'JavaScript', 'Vue.js', 'React', 'Docker', 'Git', 'REST API', 'C++', 'Linux', 'Tailwind CSS'];
        $csTitles = [
            'Junior Software Engineer',
            'Laravel Developer',
            'Full Stack Web Developer',
            'Python Backend Developer',
            'Senior PHP/Laravel Engineer',
            'Database Administrator',
            'API Integration Developer'
        ];

        $name = fake()->name();
        $title = fake()->randomElement($csTitles);
        $selectedSkills = fake()->randomElements($csSkills, rand(4, 7));
        $expYears = fake()->numberBetween(0, 8);
        $uniName = fake()->company() . ' University of Science & Technology';
        $degree = fake()->randomElement(['B.Sc. in Computer Science & Engineering', 'B.Sc. in Software Engineering']);
        $cgpa = fake()->randomFloat(2, 2.80, 4.00);
        $skillsList = implode(', ', $selectedSkills);

        // HTML Layout for DomPDF
        $html = "
            <html>
            <body style='font-family: Arial, sans-serif; line-height: 1.5; color: #333;'>
                <h2 style='margin-bottom: 2px;'>{$name}</h2>
                <h4 style='color: #555; margin-top: 0;'>{$title}</h4>
                <hr>
                <p><strong>Field:</strong> Computer Science & Software Engineering</p>
                <p><strong>Experience:</strong> {$expYears} years in web backend engineering, REST API design, and relational database management.</p>
                <p><strong>Technical Stack:</strong> {$skillsList}</p>
                <p><strong>Education:</strong> {$degree} from {$uniName} (CGPA: {$cgpa}/4.00)</p>
                <p><strong>Summary:</strong> Motivated developer with hands-on expertise in {$skillsList}. Strong understanding of object-oriented programming, MVC architecture, and database optimization.</p>
            </body>
            </html>
        ";

        // Render HTML to PDF binary
        $pdf = Pdf::loadHTML($html);
        $fileName = 'cv_' . fake()->uuid() . '.pdf';
        $filePath = 'cvs/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        return [
            'user_id'                  => User::factory(),
            'phone'                    => fake()->phoneNumber(),
            'father_name'              => fake()->name('male'),
            'mother_name'              => fake()->name('female'),
            'dob'                      => fake()->dateTimeBetween('-30 years', '-21 years')->format('Y-m-d'),
            'gender'                   => fake()->randomElement(['male', 'female']),
            'nationality'              => 'Bangladeshi',
            'present_address'          => fake()->address(),
            'permanent_address'        => fake()->address(),
            'current_title'            => $title,
            'job_field'                => 'Software Engineering',
            'skills'                   => $selectedSkills,
            'experience_years'         => $expYears,
            'expected_salary'          => fake()->numberBetween(40000, 150000),
            'university_name'          => $uniName,
            'university_degree'        => $degree,
            'university_major'         => 'Computer Science',
            'university_cgpa'          => $cgpa,
            'university_passing_year'  => fake()->numberBetween(2018, 2025),
            'college_name'             => fake()->company() . ' College',
            'college_group'            => 'Science',
            'college_gpa'              => fake()->randomFloat(2, 4.00, 5.00),
            'college_passing_year'     => fake()->numberBetween(2014, 2020),
            'high_school_name'         => fake()->company() . ' High School',
            'high_school_group'        => 'Science',
            'high_school_gpa'          => fake()->randomFloat(2, 4.00, 5.00),
            'high_school_passing_year' => fake()->numberBetween(2012, 2018),
            'cv_path'                  => $filePath,
        ];
    }
}