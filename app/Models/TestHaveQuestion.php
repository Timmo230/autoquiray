<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestHaveQuestion extends Model
{
    protected $primaryKey = ['test_id', 'question_id'];
    public $incrementing = false;
    protected $fillable = [
        'test_id',
        'question_id',
    ];

    public function test(){
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function question(){
        return $this->belongsTo(QuestionTest::class, 'question_id');
    }
}
