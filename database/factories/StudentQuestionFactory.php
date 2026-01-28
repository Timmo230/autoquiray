<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentQuestion>
 */
class StudentQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first(),
            'menssage' => $this->faker->sentence(10),
            'date_sent' => $this->faker->dateTimeBetween('2025-1-1', '2027-12-31'),
            'affair' => $this->faker->word(),
        ];
    }
}
