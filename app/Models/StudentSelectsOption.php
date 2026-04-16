<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StudentSelectsOption extends Model
{
    use HasFactory, Notifiable;

    //protected $primaryKey = ['student_id', 'option_id'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_id',
        'option_id',
    ];

    public function option(){
        return $this->belongsTo(Option::class, 'option_id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
