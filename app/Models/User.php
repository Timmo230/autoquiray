<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar de forma masiva (Mass Assignment).
     * Debes incluir aquí todos los campos que creaste en tu migración
     * para que la Factory pueda rellenarlos.
     */
    protected $fillable = [
        'document_id',
        'document_type',
        'name',
        'email',
        'type',
        'active',
        'password',
        'administrator_id',
    ];

    /**
     * Los atributos que deben estar ocultos para la serialización (por seguridad).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relación con el Estudiante (1 a 1).
     * Esto permite hacer $user->student para obtener sus datos de alumno.
     */
    public function student()
    {
        // 'user_id' es la clave foránea en la tabla students
        return $this->hasOne(Student::class, 'user_id');
    }

    public function employees()
    {
        // 'user_id' es la clave foránea en la tabla students
        return $this->hasOne(Employees::class, 'employees_id');
    }

    public function creator(){
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }
}