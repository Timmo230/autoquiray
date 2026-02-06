<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login'); 
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
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
                return back()->withErrors(['email' => 'El tipo de usuario no coincide con esta cuenta.']);
            }
            
            return match($user->type){
                'administrator' => redirect()->route('admin.dashboard'),
                'teacher' => redirect()->route('teacher.dashboard'),
                'student' => redirect()->route('student.test'),
                default => redirect('/')
            };
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    public function logout(Request $request) 
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
