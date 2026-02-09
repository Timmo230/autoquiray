<?php

namespace Database\Factories;

use App\Models\QuestionTest;
use App\Models\Teacher;
use App\Models\Option;
use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionTestFactory extends Factory
{
    protected $model = QuestionTest::class;

    protected static $tests = null;
    protected static $counter = 0;
    protected static $index = 0;
    public function definition(): array
    {
        if (is_null(self::$tests)) {
            self::$tests = Test::orderBy('id', 'asc')->get(['id', 'max_note'])->toArray();
        }

        $currentTest = self::$tests[self::$index];
        $maxQuestions = $currentTest['max_note'];

        if (self::$counter >= $maxQuestions) {
            self::$index++;
            self::$counter = 0;

            $currentTest = self::$tests[self::$index];
        }

        $testId = $currentTest['id'];
        self::$counter++;

        return [
            'id' => fake()->bothify('????????-???????-???????-???????'),
            'test_id' => $testId,
            'teacher_id' => Teacher::inRandomOrder()->first()->employees_id,
            'title' => rtrim($this->faker->sentence(3), '.'),
            'correct_option_id' => null,
        ];
    }
}