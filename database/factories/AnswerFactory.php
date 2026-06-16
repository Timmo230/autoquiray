<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Teacher;
use App\Models\StudentQuestion;
use Database\Seeders\Support\RealisticSeedCatalog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $faker = fake('es_ES');

        return [
            'id' => (string) Str::uuid(),
            'teacher_id' => Teacher::query()->inRandomOrder()->value('employees_id'),
            'question_id' => StudentQuestion::query()->inRandomOrder()->value('id'),
            'message' => $faker->randomElement(RealisticSeedCatalog::teacherAnswerMessages()),
            'date_sent' => $faker->dateTimeBetween('-4 weeks', 'now'),
        ];
    }
}
