<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Support\RealisticSeedCatalog;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'root',
            'document_id' => '00000000X',
            'document_type' => 'DNI',
            'administrator_id' => null,
            'email' => 'root@root.com',
            'password' => bcrypt('123'),
            'active' => 1,
        ]);

        foreach (RealisticSeedCatalog::namedUsers() as $profile) {
            User::factory()->create([
                'name' => $profile['name'],
                'document_id' => $profile['document_id'],
                'document_type' => 'DNI',
                'administrator_id' => null,
                'email' => $profile['email'],
                'password' => bcrypt('123'),
                'active' => true,
            ]);
        }

        User::factory(120)->create([
            'password' => bcrypt('123'),
            'active' => true,
        ]);
    }
}
