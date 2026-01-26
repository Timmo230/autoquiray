<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Psy\Readline\Hoa\FileLink;

class StudentRegistersExam extends Model
{
    protected $primaryKey = ['student_id', 'exam_id'];
    public $incrementing = false;
    protected $fillable = [
        'student_id',
        'exam_id',
        'note',
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}