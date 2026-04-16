<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuestionTest;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected static $quiestions = null;
    public function run(): void
    {
        $question = QuestionTest::all()->count();
        $question *= 3;

        \App\Models\Option::factory($question)->create();
    }
}
