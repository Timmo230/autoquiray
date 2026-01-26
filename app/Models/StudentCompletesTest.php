<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCompletesTest extends Model
{
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
