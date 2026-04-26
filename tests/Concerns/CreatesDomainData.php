<?php

namespace Tests\Concerns;

use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait CreatesDomainData
{
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    protected function createStudentUser(array $userAttributes = []): User
    {
        $user = $this->createUser($userAttributes);

        DB::table('students')->insert([
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assignRole($user->id, 'student');

        return $user;
    }

    protected function assignRole(string $userId, string $role): void
    {
        $typeId = Type::query()->firstOrCreate(['type' => $role])->id;

        DB::table('user_is_assigned_types')->updateOrInsert(
            ['user_id' => $userId, 'type_id' => $typeId],
            ['created_at' => now(), 'updated_at' => now()]
        );
    }

    protected function createPermission(string $name = 'B'): int
    {
        return DB::table('permissions')->insertGetId([
            'permission' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function createExam(int $permissionId, array $attributes = []): string
    {
        $id = (string) Str::uuid();

        DB::table('exams')->insert(array_merge([
            'id' => $id,
            'permission_id' => $permissionId,
            'date' => now()->addWeek()->toDateString(),
            'start_time' => '10:00:00',
            'type' => 'theorist',
            'price' => 25,
            'created_at' => now(),
            'updated_at' => now(),
        ], $attributes));

        return $id;
    }

    protected function createTuition(string $studentId, int $permissionId, array $attributes = []): void
    {
        DB::table('tutions')->insert(array_merge([
            'administrator_id' => null,
            'student_id' => $studentId,
            'permission_id' => $permissionId,
            'date' => now()->toDateString(),
            'start_date' => now()->subDay()->toDateString(),
            'max_end_date' => now()->addMonth()->toDateString(),
            'status' => 'matriculado',
            'price' => 499,
            'created_at' => now(),
            'updated_at' => now(),
        ], $attributes));
    }

    protected function passwordForLogin(string $plain = 'password123'): array
    {
        return [$plain, Hash::make($plain)];
    }
}
