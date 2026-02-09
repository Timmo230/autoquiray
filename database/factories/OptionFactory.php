<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Option;
use App\Models\QuestionTest;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    protected $model = Option::class;

    protected static $questions = null;
    protected static $index = 0;
    protected static $counter = 0;
    public function definition(): array
    {
        if (is_null(self::$questions)) {
            self::$questions = QuestionTest::orderBy('id', 'asc')->pluck('id')->toArray();
        }

        if (self::$counter >= 3) {
            self::$index++;
            self::$counter = 0;
        }

        $questionId = self::$questions[self::$index];
        self::$counter++;


        return [
            'id' => fake()->bothify('????????-???????-???????-???????'),
            'question_id' => $questionId,
            'option' => $this->faker->sentence(10),
        ];
    }
}

