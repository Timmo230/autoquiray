<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Type extends Model
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'type',
    ];

    public function user_is_assigned_types(){
        return $this->hasMany(UserIsAssignedTypes::class, 'type_id');
    }
}
