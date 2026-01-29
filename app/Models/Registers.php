<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Registers extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = ['student_id', 'exam_id'];
    public $incrementing = false;

    protected $fillable = [
        'student_id',
        'exam_id',
        'note',
    ];

    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
