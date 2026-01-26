<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'permission',
    ];

    public function are_associated(){
        return $this->hasmany(PermissionAreAssociatedTest::class, 'permission_id');
    }

    public function is_tought_in(){
        return $this->hasmany(PermissionAreToughtInClasse::class, 'permission_id');
    }

    public function tution(){
        return $this->hasmany(Tution::class, 'permission_id');
    }

    public function is_examinated_in(){
        return $this->hasmany(Exam::class, 'permission_id');
    }
}
