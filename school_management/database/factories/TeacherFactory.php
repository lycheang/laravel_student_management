<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_name' => $this->faker->name,
            'teacher_email' => $this->faker->unique()->safeEmail,
            'teacher_password' => Hash::make('test123'),
            'image' => 'as.jpeg',
            'phone' => $this->faker->phoneNumber,
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
