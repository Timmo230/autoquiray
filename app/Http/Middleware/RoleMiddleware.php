<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = DB::table('users', 'u')
            ->join('user_is_assigned_types as aut', 'u.id', '=', 'aut.user_id')
            ->join('types as t', 't.id', '=', 'aut.type_id')
            ->where('u.id', '=', Auth::id())
            ->where('t.type', '=', $roles)
            ->select('t.type')
            ->first();

        if(!$user){
            return redirect('login');
        }

        if(!in_array($user->type, $roles)){
            abort(403, 'No tienes permiso');
        }

        return $next($request);
    }
}