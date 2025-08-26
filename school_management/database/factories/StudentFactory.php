<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $enrollmentDate = $this->faker->dateTimeBetween('-4 years', 'now');
        
        return [
            'student_name' => $this->faker->name,
            'student_email' => $this->faker->unique()->safeEmail,
            'student_password' => Hash::make('test123'),
            'image' => 'as.jpeg',
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
            'major' => $this->faker->randomElement(['Computer Science', 'Business', 'Engineering', 'Arts', 'Science']),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'is_graduate' => false,
            'enrollment_date' => $enrollmentDate,
            'graduation_date' => null,
        ];
    }
}
