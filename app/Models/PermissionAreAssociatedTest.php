<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionAreAssociatedTest extends Model
{
    protected $primaryKey = ['test_id', 'permission_id'];
    public $incrementing = false;
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
