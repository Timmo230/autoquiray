<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tution(){
        return $this->hasmany(Tution::class, 'student_id');
    }

    public function register(){
        return $this->hasmany(Registers::class, 'student_id');
    }

    public function completes(){
        return $this->hasmany(StudentCompletesTest::class, 'student_id');
    }

    public function reserves(){
        return $this->hasmany(StudentReservesClasse::class, 'student_id');
    }

    public function question(){
        return $this->hasmany(StudentQuestion::class, 'student_id');
    }
}
