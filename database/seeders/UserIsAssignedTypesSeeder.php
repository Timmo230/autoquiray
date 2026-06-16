<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\UserIsAssignedTypes;
use Database\Seeders\Support\RealisticSeedCatalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserIsAssignedTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeMap = Type::query()->pluck('id', 'type');
        $namedUsers = collect(RealisticSeedCatalog::namedUsers())->keyBy('email');

        foreach (User::query()->orderBy('created_at')->get(['id', 'email']) as $user) {
            $roles = match (true) {
                $user->email === 'root@root.com' => ['administrator', 'teacher', 'student'],
                $namedUsers->has($user->email) => $namedUsers[$user->email]['roles'],
                default => [fake()->randomElement(['student', 'student', 'student', 'teacher', 'administrator'])],
            };

            foreach ($roles as $role) {
                UserIsAssignedTypes::query()->firstOrCreate([
                    'user_id' => $user->id,
                    'type_id' => $typeMap[$role],
                ]);
            }
        }
    }
}
