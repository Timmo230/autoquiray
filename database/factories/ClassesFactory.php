<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use App\Models\Timetable;
use Database\Seeders\Support\RealisticSeedCatalog;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    protected static int $titleIndex = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = RealisticSeedCatalog::classTitles();

        return [
            'teacher_id' => Teacher::query()->inRandomOrder()->value('employees_id'),
            'timetable_id' => Timetable::query()->inRandomOrder()->value('id'),
            'title' => $titles[self::$titleIndex++ % count($titles)],
            'max_students' => fake('es_ES')->numberBetween(8, 20),
        ];
    }
}
