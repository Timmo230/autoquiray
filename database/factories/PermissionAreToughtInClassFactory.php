<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classes;
use App\Models\Permission;
use App\Models\PermissionAreToughtInClasse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PermissionAreToughtInClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do{
            $class_id = Classes::inRamdomOrder()->first()?->id;
            $permissionId = Permission::inRandomOrder()->first()?->id;;

            if (!$class_id || !$permissionId) {
                throw new \Exception("¡Cuidado! Necesitas tener al menos un Test y una Class en la base de datos antes de usar este Factory.");
            }

            $exist = PermissionAreToughtInClasse::where('class_id', $class_id)
            ->where('permission_id', $permissionId)->exist();
        } while($exist);

        return [
            'class_id' => $class_id->id,
            'permission_id' => $permissionId->id,
        ];
    }
}
