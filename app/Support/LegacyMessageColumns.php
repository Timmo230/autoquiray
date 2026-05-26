<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;

class LegacyMessageColumns
{
    public static function studentQuestions(): string
    {
        return Schema::hasColumn('student_questions', 'message') ? 'message' : 'menssage';
    }

    public static function answers(): string
    {
        return Schema::hasColumn('answers', 'message') ? 'message' : 'menssage';
    }
}
