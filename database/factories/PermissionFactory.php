<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PermissionFactory extends Factory
{
    protected static $permissions = ['A', 'A1', 'A2', 'B', 'BTP', 'C', 'C1', 'D', 'D1', 'E'];

    public function definition(): array
    {
        return [
            'permission' => array_shift(self::$permissions),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
