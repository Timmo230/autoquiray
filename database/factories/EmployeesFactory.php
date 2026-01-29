<?php

namespace Database\Factories;

use App\Models\Employees;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPUnit\Framework\isNull;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employees>
 */
class EmployeesFactory extends Factory
{
    protected $model = Employees::class;

    protected static $availableUserIds = null;
    public function definition(): array
    {
        if(is_null(self::$availableUserIds)){
            self::$availableUserIds = User::whereIn('type', ['teacher', 'administrator'])
                            ->whereDoesntHave('employees')
                            ->pluck('id')->toArray();
        }

        $userId = array_shift(self::$availableUserIds);

        return [
            'user_id' => $userId,
            'salary' => $this->faker->randomFloat(2, 1500, 4500),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
