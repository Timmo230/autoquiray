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
        do{
            $testId = Test::inRamdomOrder()->first()?->id;
            $permissionId = Permission::inRandomOrder()->first()?->id;;

            if (!$testId || !$permissionId) {
                throw new \Exception("¡Cuidado! Necesitas tener al menos un Test y un Permission en la base de datos antes de usar este Factory.");
            }

            $exist = PermissionAreAssociatedTest::where('test_id', $testId)
            ->where('permission_id', $permissionId)->exist();
        } while($exist);

        return [
            'test_id' => $testId->id,
            'permission_id' => $permissionId->id,
        ];
    }
}
