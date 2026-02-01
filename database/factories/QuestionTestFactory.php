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
            self::$tests = Test::orderBy('id', 'asc')->pluck('id')->toArray();
        }

        if (self::$counter >= 30) {
            self::$index++;
            self::$counter = 0;
        }

        $testId = self::$tests[self::$index];
        self::$counter++;

        return [
            'test_id' => $testId,
            'teacher_id' => Teacher::inRandomOrder()->first()->employees_id,
            'title' => rtrim($this->faker->sentence(), '.'),
            'correct_option_id' => null,
        ];
    }
}