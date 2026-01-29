<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Timetable extends Model
{
    use HasFactory, Notifiable;
    
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
