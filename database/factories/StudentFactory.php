<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Student;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;
    
    protected static $availableUserIds =  null;

    public function definition(): array
    {
        if(is_null(self::$availableUserIds)){
            self::$availableUserIds = User::whereIn('type', ['student'])
                ->whereDoesntHave('student')->pluck('id')->toArray();
        }

        $selected = array_shift(self::$availableUserIds);
        return [
            'user_id' => $selected,
        ];
    }
}