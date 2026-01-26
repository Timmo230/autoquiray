<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'administrator_id',
        'date',
        'start_time',
        'end_time',
    ];

    public function administrator(){
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }

    public function class(){
        return $this->hasMany(Classes::class, 'timetable_id');
    }
}
