<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'teacher_id',
        'title',
        'max_note',
    ];

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function student(){
        return $this->hasMany(StudentCompletesTest::class, 'test_id');
    }

    public function question(){
        return $this->hasMany(QuestionTest::class, 'test_id');
    }

    public function permission(){
        return $this->hasMany(PermissionAreAssociatedTest::class, 'test_id');
    }
}
