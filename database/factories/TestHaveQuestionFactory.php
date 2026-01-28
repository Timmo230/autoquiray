<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Test;
use App\Models\QuestionTest;
use App\Models\TestHaveQuestion;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestHaveQuestion>
 */
class TestHaveQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do{
            $testId = Test::inRamdomOrder()->first()?->id;
            $questionId = QuestionTest::inRandomOrder()->first()?->id;;

            if (!$testId || !$questionId) {
                throw new \Exception("¡Cuidado! Necesitas tener al menos un Test y un Question en la base de datos antes de usar este Factory.");
            }

            $exist = TestHaveQuestion::where('test_id', $testId)
            ->where('question_id', $questionId)->exist();
        } while($exist);

        return [
            'test_id' => $testId->id,
            'question_id' => $questionId->id,
        ];
    }
}
