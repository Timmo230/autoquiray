<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use Database\Seeders\Support\RealisticSeedCatalog;
use Illuminate\Support\Str;

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
        $faker = fake('es_ES');

        return [
            'id' => (string) Str::uuid(),
            'student_id' => Student::query()->inRandomOrder()->value('user_id'),
            'message' => $faker->randomElement(RealisticSeedCatalog::studentQuestionMessages()),
            'date_sent' => $faker->dateTimeBetween('-6 weeks', 'now'),
            'affair' => $faker->randomElement(RealisticSeedCatalog::studentQuestionSubjects()),
        ];
    }
}
