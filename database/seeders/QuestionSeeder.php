<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\QuestionTest;
use App\Models\Test;
use Database\Seeders\Support\RealisticSeedCatalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionBank = RealisticSeedCatalog::questionBank();

        foreach (Test::query()->orderBy('created_at')->get() as $test) {
            $teacherId = $test->teacher_id;
            $questions = $questionBank[$test->type] ?? $questionBank['dgt'];

            for ($index = 0; $index < $test->max_note; $index++) {
                $template = $questions[$index % count($questions)];

                $question = new QuestionTest();
                $question->id = (string) Str::uuid();
                $question->test_id = $test->id;
                $question->teacher_id = $teacherId;
                $question->title = $template['title'];
                $question->correct_option_id = null;
                $question->save();

                $createdOptions = [];
                foreach ($template['options'] as $optionText) {
                    $option = new Option();
                    $option->id = (string) Str::uuid();
                    $option->question_id = $question->id;
                    $option->option = $optionText;
                    $option->save();

                    $createdOptions[] = $option;
                }

                $question->update([
                    'correct_option_id' => $createdOptions[$template['correct']]->id,
                ]);
            }
        }
    }
}
