<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Permission;
use App\Models\PermissionAreAssociatedTest;

class PermissionAreAssociatedTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $created = 0;

        while ($created < 150) {
            $permission = Permission::inRandomOrder()->first();
            $test    = Test::inRandomOrder()->first();

            $register = PermissionAreAssociatedTest::firstOrCreate(
                [
                    'permission_id' => $permission->id,
                    'test_id'    => $test->id,
                ]
            );

            if ($register->wasRecentlyCreated) {
                $created++;
            }
        }
    }
}
