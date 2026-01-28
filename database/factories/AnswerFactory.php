<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Teacher;
use App\Models\StudentQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::inRandomOrder()->first(),
            'question_id' => StudentQuestion::inRandomOrder()->first(),
            'menssage' => $this->faker->paragraph(),
            'date_sent' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
