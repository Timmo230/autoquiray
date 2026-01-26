<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'question_id',
        'option',
    ];

    public function question(){
        return $this->belongsTo(QuestionTest::class, 'question_id');
    }
}
