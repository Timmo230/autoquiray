<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $a1 = \App\Models\Permission::factory()->create([
            'name' => 'root',
            'document_id' => '00000000X',
            'document_type' => 'DNI',
            'type' => 'administrator',
            'administrator_id' => null,
            'email' => 'root@root.com',
            'active' => true,
            'password' => bcrypt('123'),
        ]);
    }
}
