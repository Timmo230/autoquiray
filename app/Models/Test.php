<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Test extends Model
{
    use HasFactory, Notifiable;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'teacher_id',
        'title',
        'max_note',
        'max_time',
        'type'
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
