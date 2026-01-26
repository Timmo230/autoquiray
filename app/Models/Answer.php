<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
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
