<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'permission_id',
        'date',
        'start_time',
        'type',
        'price',
    ];

    public function register(){
        return $this->hasmany(StudentRegistersExam::class, 'exam_id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
