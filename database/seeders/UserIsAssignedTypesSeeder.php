<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserIsAssignedTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected static $users = null;
    public function run(): void
    {
        if(is_null(self::$users)){
            self::$users = User::orderBy('created_at', 'asc')->pluck('id')->toArray();
        }

        $user = array_shift(self::$users);

        
        $rootUser = \App\Models\UserIsAssignedTypes::factory()->create([
            'user_id' => (string) $user,
            'type_id' => 3,
        ]);

        for($counter = 0; $counter < 3; $counter++){
            $user = array_shift(self::$users);
            
            $administrators = \App\Models\UserIsAssignedTypes::factory()->create([
                'user_id' => (string) $user,
                'type_id' => 3,
            ]);
        }

        for($counter = 0; $counter < 10; $counter++){
            $user = array_shift(self::$users);
            
            $administrators = \App\Models\UserIsAssignedTypes::factory()->create([
                'user_id' => (string) $user,
                'type_id' => 2,
            ]);
        }

        for($counter = 0; $counter < 1000; $counter++){
            $user = array_shift(self::$users);
            
            $administrators = \App\Models\UserIsAssignedTypes::factory()->create([
                'user_id' => (string) $user,
                'type_id' => 1,
            ]);
        }
    }
}
