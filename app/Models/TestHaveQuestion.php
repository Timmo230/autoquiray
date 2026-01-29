<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class TestHaveQuestion extends Model
{
    use HasFactory, Notifiable;
    
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
