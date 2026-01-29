<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StudentCompletesTest extends Model
{
    use HasFactory, Notifiable;
    
    protected $primaryKey = ['student_id', 'test_id'];
    public $incrementing = false;
    protected $fillable = [
        'student_id',
        'test_id',
        'last_note',
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function test(){
        return $this->belongsTo(Test::class, 'test_id');
    }
}
