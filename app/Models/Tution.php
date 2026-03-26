<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Tution extends Model
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'administrator_id',
        'student_id',
        'permission_id',
        'date',
        'start_date',
        'max_end_date',
        'status',
        'price',
    ];

    public function administrator(){
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
