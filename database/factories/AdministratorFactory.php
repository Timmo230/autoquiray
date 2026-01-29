<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employees;
use App\Models\Administrator;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrator>
 */
class AdministratorFactory extends Factory
{
    protected $model = Administrator::class;

    protected static $availableUserIds = null;

    public function definition(): array
    {
        if(is_null(self::$availableUserIds)){
            self::$availableUserIds = Employees::whereHas('user', function ($query){
                $query->where('type', 'administrator');
            })->whereDoesntHave('administrator')->pluck('user_id')
            ->toArray();
        }

        $userId = array_shift(self::$availableUserIds);

        return [
            'employees_id'   => $userId,
        ];
    }
}
