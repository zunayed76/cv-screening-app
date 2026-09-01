<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Job;
use App\Models\CandidateProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default password for all generated users (for easy testing on any PC)
        $defaultPassword = Hash::make('password');

        // 1. Create 10 Company Users
        $companies = User::factory()->count(10)->create([
            'role'     => 'company',
            'password' => $defaultPassword,
        ]);

        // 2. Create 200 Jobs distributed among the 10 Companies
        foreach (range(1, 200) as $i) {
            Job::factory()->create([
                'user_id' => $companies->random()->id,
            ]);
        }

        // 3. Create 500 Candidate Users with corresponding CandidateProfiles
        User::factory()->count(500)->create([
            'role'     => 'candidate',
            'password' => $defaultPassword,
        ])->each(function ($user) {
            CandidateProfile::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}