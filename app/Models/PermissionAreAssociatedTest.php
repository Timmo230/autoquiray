<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PermissionAreAssociatedTest extends Model
{
    use HasFactory, Notifiable;
    
    protected $primaryKey = ['test_id', 'permission_id'];
    public $incrementing = false;
    protected $table = 'permissions_are_associated_test';
    protected $fillable = [
        'test_id',
        'permission_id',
    ];

    public function test(){
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
