<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class ContactController extends Controller
{
    public function uploadMessage(Request $request){
        
        $request->validate([
            'tipo' => 'required',
            'menssage' => 'required',
            'detalle_asunto' => 'required_if:tipo,otro|nullable|string|max:255'
        ]);
        
        if (Auth::check()) {
            $user_id = Auth::id();
        
            $affair = $request->filled('detalle_asunto') 
                    ? $request->detalle_asunto 
                    : $request->tipo;

            DB::table('student_questions')
            ->insert([
                'id' => (string) Str::uuid(),
                'student_id' => $user_id,
                'menssage' => $request->menssage,
                'date_sent' => now(),
                'affair' => $affair,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect('/contacto')->with('success', '¡Mensaje enviado con éxito!');
        }

        return redirect('/')->with('error', 'Error al subir la pregunta');
    }
}
