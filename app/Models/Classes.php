<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Classes extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'teacher_id',
        'timetable_id',
        'title',
        'maximun_students',
    ];

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function timetable(){
        return $this->belongsTo(Timetable::class, 'timetable_id');
    }

    public function permission(){
        return $this->hasMany(PermissionAreToughtInClasse::class, 'class_id');
    }

    public function student(){
        return $this->hasMany(StudentReservesClasse::class, 'class_id');
    }
}
