<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use Database\Seeders\Support\RealisticSeedCatalog;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{
    protected static int $definitionIndex = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $definitions = RealisticSeedCatalog::testDefinitions();
        $definition = $definitions[self::$definitionIndex % count($definitions)];
        self::$definitionIndex++;

        return [
            'id' => (string) Str::uuid(),
            'teacher_id' => Teacher::query()->inRandomOrder()->value('employees_id'),
            'title' => $definition['title'],
            'max_note' => $definition['question_count'],
            'max_time' => $definition['question_count'],
            'type' => $definition['type'],
        ];
    }
}
