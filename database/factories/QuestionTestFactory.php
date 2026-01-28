<?php

namespace Database\Factories;

use App\Models\QuestionTest;
use App\Models\Teacher;
use App\Models\Option; // Asumiendo que tu modelo se llama Option
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionTestFactory extends Factory
{
    protected $model = QuestionTest::class;

    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::inRandomOrder()->first()?->id ?? Teacher::factory(),
            'title' => rtrim($this->faker->sentence(), '.'),
            'correct_option' => null, 
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (QuestionTest $question) {
            $options = Option::factory()->count(3)->create([
                'question_id' => $question->id
            ]);

            $question->update([
                'correct_option' => $options->random()->id
            ]);
        });
    }
}