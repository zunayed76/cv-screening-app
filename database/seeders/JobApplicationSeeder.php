<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $job = Job::find(202);

        if (!$job) {
            $this->command->error("Job ID 202 not found!");
            return;
        }

        // Get candidate users with profiles
        $candidateUsers = User::whereHas('profile')->get();

        foreach ($candidateUsers as $user) {
            JobApplication::firstOrCreate(
                [
                    'job_id'  => $job->id,
                    'user_id' => $user->id,
                ],
                [
                    'status' => 'Applied',
                ]
            );
        }

        $this->command->info("Attached " . $candidateUsers->count() . " candidates to Job ID 202.");
    }
}