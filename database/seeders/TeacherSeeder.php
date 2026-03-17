<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employees;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected static $users = null;
    public function run(): void
    {
        if(is_null(self::$users)){
            self::$users = DB::table('users as u')
                ->join('user_is_assigned_types as uat', 'u.id', '=', 'uat.user_id')
                ->join('types','uat.type_id','=','types.id')
                ->where('type', '=', 'teacher')
                ->pluck('u.id')
                ->toArray();
        }

        foreach(self::$users as $user){
            \App\Models\Teacher::factory()->create([
                'employees_id' => $user,
            ]);
        }
    }
}
