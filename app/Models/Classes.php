<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
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
