<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nette\Utils\Type;
use \App\Models\Type as Types;

class UserIsAssignedTypes extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = ['user_id', 'type_id'];
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'type_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type(){
        return $this->belongsTo(Types::class, 'type_id');
    }
}
