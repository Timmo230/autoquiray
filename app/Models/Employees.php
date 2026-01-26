<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'salary',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function administrator(){
        return $this->hasOne(Administrator::class, 'employees_id');
    }

    public function teacher(){
        return $this->hasOne(Teacher::class, 'employees_id');
    }
}
