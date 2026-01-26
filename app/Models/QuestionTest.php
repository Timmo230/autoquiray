<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionTest extends Model
{
    protected $fillable = [
        'teacher_id',
        'title',
        'correct_option',
    ];

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function test(){
        return $this->hasMany(TestHaveQuestion::class, 'question_id');
    }

    public function option(){
        return $this->hasMany(Option::class, 'question_id');
    }
}
