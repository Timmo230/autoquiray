<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Exam extends Model
{
    use HasFactory, Notifiable;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'permission_id',
        'date',
        'start_time',
        'type',
        'price',
    ];

    public function register(){
        return $this->hasmany(Registers::class, 'exam_id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
