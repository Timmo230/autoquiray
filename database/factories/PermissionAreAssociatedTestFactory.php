<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Test;
use App\Models\Permission;
use App\Models\PermissionAreAssociatedTest;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PermissionAreAssociatedTest>
 */
class PermissionAreAssociatedTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $testId = Test::inRandomOrder()->first()?->id;
        $permissionId = Permission::inRandomOrder()->first()?->id;

        return [
            'test_id' => $testId->id,
            'permission_id' => $permissionId->id,
        ];
    }
}
