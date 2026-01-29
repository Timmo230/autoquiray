<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $primaryKey = 'employees_id';
    public $incrementing = false;
    protected $fillable = [
        'employees_id',
        'salary',
    ];

    public function employees(){
        return $this->belongsTo(Employees::class, 'employees_id');
    }

    public function class(){
        return $this->hasMany(Classes::class, 'teacher_id');
    }

    public function answer(){
        return $this->hasMany(Answer::class, 'teacher_id');
    }

    public function test(){
        return $this->hasMany(Test::class, 'teacher_id');
    }

    public function questionTest(){
        return $this->hasMany(QuestionTest::class, 'teacher_id');
    }
}
