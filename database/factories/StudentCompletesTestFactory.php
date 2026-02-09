<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Test;
use App\Models\StudentCompletesTest;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentCompletesTest>
 */
class StudentCompletesTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'last_note' => $this->faker->numberBetween(24, 30),
        ];
    }
}
