<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'document_id',
        'document_type',
        'name',
        'email',
        'active',
        'administrator_id',
    ];
    
    protected $hidden = [
        'password',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    public function employees()
    {
        return $this->hasOne(Employees::class, 'user_id');
    }

    public function administrator(){
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }

    public function user_is_assigned_tyops(){
        return $this->hasMany(UserIsAssignedTypes::class, 'user_id');
    }
}