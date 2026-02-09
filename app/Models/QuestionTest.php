<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class QuestionTest extends Model
{
    use HasFactory, Notifiable;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'test_id',
        'teacher_id',
        'title',
        'correct_option_id',
    ];

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function test(){
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function option(){
        return $this->hasMany(Option::class, 'question_id');
    }
}
