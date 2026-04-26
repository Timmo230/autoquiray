<?php

namespace App\Support;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRoleManager
{
    public static function getAvailableRoles(?string $userId = null): Collection
    {
        $userId ??= Auth::id();

        if (! $userId) {
            return collect();
        }

        return DB::table('user_is_assigned_types as uat')
            ->join('types as t', 'uat.type_id', '=', 't.id')
            ->where('uat.user_id', $userId)
            ->orderBy('t.type')
            ->pluck('t.type')
            ->unique()
            ->values();
    }

    public static function getActiveRole(?string $userId = null): ?string
    {
        $activeRole = session('active_role');

        if (! $activeRole) {
            return null;
        }

        $roles = self::getAvailableRoles($userId);

        return $roles->contains($activeRole) ? $activeRole : null;
    }

    public static function setActiveRole(string $role): void
    {
        session([
            'active_role' => $role,
            'available_roles' => self::getAvailableRoles()->all(),
        ]);
    }

    public static function clearRoleSession(): void
    {
        session()->forget(['active_role', 'available_roles']);
    }

    public static function syncRoleSession(): void
    {
        session(['available_roles' => self::getAvailableRoles()->all()]);
    }

    public static function redirectForRole(string $role): RedirectResponse
    {
        return match ($role) {
            'administrator' => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.testType'),
            default => redirect()->route('home'),
        };
    }
}
