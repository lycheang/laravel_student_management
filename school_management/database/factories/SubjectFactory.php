<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'subject_name' => $this->faker->words(3, true),
        'teacher_id' => \App\Models\Teacher::factory(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
}
}
