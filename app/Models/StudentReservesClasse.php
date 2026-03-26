<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StudentReservesClasse extends Model
{
    use HasFactory, Notifiable;
    
    protected $primaryKey = ['student_id', 'class_id'];
    public $incrementing = false;
    protected $table = 'students_reserves_classes';
    protected $fillable = [
        'student_id',
        'class_id',
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function class(){
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
