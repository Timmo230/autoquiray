<?php

namespace App\Http\Middleware;

use App\Support\UserRoleManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! Auth::check()) {
            return redirect('login');
        }

        $availableRoles = UserRoleManager::getAvailableRoles();
        $activeRole = UserRoleManager::getActiveRole();

        if (! $activeRole) {
            if ($availableRoles->count() === 1) {
                UserRoleManager::setActiveRole($availableRoles->first());
                $activeRole = UserRoleManager::getActiveRole();
            } else {
                return redirect()->route('role.selection');
            }
        }

        if (! in_array($activeRole, $roles, true)) {
            abort(418);
        }

        return $next($request);
    }
}
