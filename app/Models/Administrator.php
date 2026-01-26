<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Time;

class Administrator extends Model
{
    protected $primaryKey = 'employees_id';
    public $incrementing = false;
    protected $fillable = [
        'employees_id',
    ];

    public function tution(){
        return $this->hasMany(Tution::class, 'administrator_id');
    }

    public function user(){
        return $this->hasMany(User::class, 'administrator_id');
    }

    public function timetable(){
        return $this->hasMany(Timetable::class, 'administrator_id');
    }

    public function employe(){
        return $this->belongsTo(Employees::class, 'employees_id');
    }
}
