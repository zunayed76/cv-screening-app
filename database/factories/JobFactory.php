<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        return [
            'title'       => fake()->jobTitle(),
            'location'    => fake()->city() . ', ' . fake()->country(),
            'type'        => fake()->randomElement(['full-time', 'part-time', 'contract', 'remote']),
            'description' => fake()->paragraphs(3, true),
            'deadline'    => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
        ];
    }
}