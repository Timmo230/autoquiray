<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use App\Models\Employees;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;
    protected static $availableUserIds = null;
    
    public function definition(): array
    {
        if(is_null(self::$availableUserIds)){
            self::$availableUserIds = Employees::whereHas('user', function ($query){
                $query->where('type', 'teacher');
            })->whereDoesntHave('teacher')->pluck('user_id')->toArray();
        }
        
        $userId = array_shift(self::$availableUserIds);
        return [
            'employees_id'   => $userId,
        ];
    }
}
