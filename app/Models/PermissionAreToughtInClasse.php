<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionAreToughtInClasse extends Model
{
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
