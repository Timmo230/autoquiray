<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentQuestion extends Model
{
    protected $fillable = [
        'student_id',
        'menssage',
        'date_sent',
        'affair',
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function answer(){
        return $this->hasMany(Answer::class, 'question_id');
    }
}
