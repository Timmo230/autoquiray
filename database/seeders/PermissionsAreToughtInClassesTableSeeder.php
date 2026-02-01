<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Classes;
use App\Models\PermissionAreToughtInClasse;

class PermissionsAreToughtInClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $created = 0;

        while ($created < 500) {
            $permission = Permission::inRandomOrder()->first();
            $class    = Classes::inRandomOrder()->first();

            $register = PermissionAreToughtInClasse::firstOrCreate(
                [
                    'class_id' => $class->id,
                    'permission_id'    => $permission->id,
                ]
            );

            if ($register->wasRecentlyCreated) {
                $created++;
            }
        }
    }
}
