<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
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
            'type' => 'required'
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'El tipo de usuario no coincide con esta cuenta.'])
                ->with('plausible_events', [
                    ['name' => 'login_failed', 'props' => ['reason' => 'user_not_found', 'role' => $request->type]]
                ]);
        }

        if($user->password == null && $request->password == null){
            return view('auth.changePasswd', [
                'email' => $request->email,
                'type' => $request->type
            ]);
        }

        $credentials = $request->only(['email', 'password']);
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = DB::table('users', 'u')
            ->join('user_is_assigned_types as aut', 'u.id', '=', 'aut.user_id')
            ->join('types as t', 't.id', '=', 'aut.type_id')
            ->where('u.id', '=', Auth::id())
            ->where('t.type', '=', $request->type)
            ->select('t.type')
            ->first();
    
            if (!$user) {
                Auth::logout();
                return back()
                    ->withErrors(['email' => 'El tipo de usuario no coincide con esta cuenta.'])
                    ->with('plausible_events', [
                        ['name' => 'login_failed', 'props' => ['reason' => 'role_mismatch', 'role' => $request->type]]
                    ]);
            }
            
            return match($user->type){
                'administrator' => redirect()->route('admin.dashboard')->with('plausible_events', [
                    ['name' => 'login_success', 'props' => ['role' => 'administrator']]
                ]),
                'teacher' => redirect()->route('teacher.dashboard')->with('plausible_events', [
                    ['name' => 'login_success', 'props' => ['role' => 'teacher']]
                ]),
                'student' => redirect()->route('student.testType')->with('plausible_events', [
                    ['name' => 'login_success', 'props' => ['role' => 'student']]
                ]),
                default => redirect('/')->with('plausible_events', [
                    ['name' => 'login_success', 'props' => ['role' => 'unknown']]
                ])
            };
        }

        return back()
            ->withErrors(['email' => 'Credenciales incorrectas.'])
            ->with('plausible_events', [
                ['name' => 'login_failed', 'props' => ['reason' => 'invalid_credentials', 'role' => $request->type]]
            ]);
    }

    public function logout(Request $request) 
    {
        Auth::logout();
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
}
