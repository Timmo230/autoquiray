<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PermissionAreToughtInClasse extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'permissions_are_tought_in_classes';
    protected $primaryKey = ['class_id', 'permission_id'];
    public $incrementing = false;
    protected $fillable = [
        'class_id',
        'permission_id',
    ];

    public function class(){
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
