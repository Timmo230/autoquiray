<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Answer extends Model
{
    use HasFactory, Notifiable;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'teacher_id',
        'question_id',
        'menssage',
        'date_sent',
    ];

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function studentQuestion(){
        return $this->belongsTo(StudentQuestion::class, 'question_id');
    }
}
