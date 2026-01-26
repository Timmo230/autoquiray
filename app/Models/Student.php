<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, Notifiable;


    public function tution(){
        return $this->hasmany(Tution::class, 'student_id');
    }

    public function register(){
        return $this->hasmany(Register::class, 'student_id');
    }

    public function completes(){
        return $this->hasmany(Completes::class, 'student_id');
    }

    public function reserves(){
        return $this->hasmany(Completes::class, 'student_id');
    }
}
