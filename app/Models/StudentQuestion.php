<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StudentQuestion extends Model
{
    use HasFactory, Notifiable, HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'student_id',
        'message',
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
