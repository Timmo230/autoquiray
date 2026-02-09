<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Option extends Model
{
    use HasFactory, Notifiable;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'question_id',
        'option',
    ];

    public function question(){
        return $this->belongsTo(QuestionTest::class, 'question_id');
    }
}
