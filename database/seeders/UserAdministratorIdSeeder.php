<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserAdministratorIdSeeder extends Seeder
{
    public function run(): void
    {
        $rootId = User::query()
            ->where('email', 'root@root.com')
            ->value('id');

        if (! $rootId || ! Administrator::query()->where('employees_id', $rootId)->exists()) {
            return;
        }

        $users = User::query()
            ->where('id', '!=', $rootId)
            ->get();

        foreach ($users as $user) {
            $user->update([
                'administrator_id' => $rootId,
            ]);
        }

        User::query()->where('id', $rootId)->update([
            'administrator_id' => null,
        ]);
    }
}
