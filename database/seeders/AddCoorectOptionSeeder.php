<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\QuestionTest;
use App\Models\Option;

class AddCoorectOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = QuestionTest::all();

        foreach ($questions as $question) {
            $optionSelected = Option::where('question_id', $question->id)
                            ->inRandomOrder()
                            ->first();
            $question->update([
                'correct_option_id' => $optionSelected->id,
            ]);
        }
    }
}
