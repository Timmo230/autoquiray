<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Support\UserRoleManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login'); 
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable',
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'No existe ninguna cuenta con ese correo.'])
                ->with('plausible_events', [
                    ['name' => 'login_failed', 'props' => ['reason' => 'user_not_found']]
                ]);
        }

        if($user->password == null && $request->password == null){
            return view('auth.changePasswd', [
                'email' => $request->email,
            ]);
        }

        $credentials = $request->only(['email', 'password']);
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $roles = UserRoleManager::getAvailableRoles();

            if ($roles->isEmpty()) {
                Auth::logout();
                UserRoleManager::clearRoleSession();
                return back()
                    ->withErrors(['email' => 'Tu cuenta no tiene roles asignados.'])
                    ->with('plausible_events', [
                        ['name' => 'login_failed', 'props' => ['reason' => 'no_roles_assigned']]
                    ]);
            }

            UserRoleManager::syncRoleSession();

            if ($roles->count() === 1) {
                $role = $roles->first();
                UserRoleManager::setActiveRole($role);

                return UserRoleManager::redirectForRole($role)->with('plausible_events', [
                    ['name' => 'login_success', 'props' => ['role' => $role]]
                ]);
            }

            return redirect()->route('role.selection')->with('plausible_events', [
                ['name' => 'login_success', 'props' => ['role' => 'multiple']]
            ]);
        }

        return back()
            ->withErrors(['email' => 'Credenciales incorrectas.'])
            ->with('plausible_events', [
                ['name' => 'login_failed', 'props' => ['reason' => 'invalid_credentials']]
            ]);
    }

    public function showRoleSelection()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $roles = UserRoleManager::getAvailableRoles();

        if ($roles->isEmpty()) {
            Auth::logout();
            UserRoleManager::clearRoleSession();

            return redirect()
                ->route('login')
                ->with('error', 'Tu cuenta no tiene roles asignados.');
        }

        if ($roles->count() === 1) {
            $role = $roles->first();
            UserRoleManager::setActiveRole($role);

            return UserRoleManager::redirectForRole($role);
        }

        return view('auth.selectRole', [
            'roles' => $roles,
        ]);
    }

    public function selectRole(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $roles = UserRoleManager::getAvailableRoles();

        $request->validate([
            'role' => ['required', 'string', 'in:' . $roles->implode(',')],
        ]);

        $role = $request->input('role');

        UserRoleManager::setActiveRole($role);

        return UserRoleManager::redirectForRole($role)->with('success', 'Has entrado como ' . $this->getRoleLabel($role) . '.');
    }

    public function logout(Request $request) 
    {
        Auth::logout();
        UserRoleManager::clearRoleSession();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('plausible_events', [
            ['name' => 'logout', 'props' => []]
        ]);
    }

    public function changePassword(Request $request){
        try {
            DB::table('users')
                ->where('email','=', $request->email)
                ->update([
                    'password'=> Hash::make($request->password),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente.'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar la contraseña.'
            ], 500);
        }
    }

    protected function getRoleLabel(string $role): string
    {
        return match ($role) {
            'administrator' => 'administrador',
            'teacher' => 'profesor',
            'student' => 'alumno',
            default => $role,
        };
    }
}
