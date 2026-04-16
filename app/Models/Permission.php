<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Permission extends Model
{
    use HasFactory, Notifiable;
    
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
