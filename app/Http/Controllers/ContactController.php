<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class ContactController extends Controller
{
    public function messages()
    {
        $userId = Auth::id();

        $questions = DB::table('student_questions')
            ->where('student_id', $userId)
            ->orderByDesc('date_sent')
            ->select(
                'id',
                'affair',
                'menssage',
                'date_sent',
                'created_at'
            )
            ->get();

        $answers = DB::table('answers as a')
            ->leftJoin('teachers as t', 't.employees_id', '=', 'a.teacher_id')
            ->leftJoin('employees as e', 'e.user_id', '=', 't.employees_id')
            ->leftJoin('users as u', 'u.id', '=', 'e.user_id')
            ->whereIn('a.question_id', $questions->pluck('id'))
            ->orderBy('a.date_sent')
            ->select(
                'a.id',
                'a.question_id',
                'a.menssage',
                'a.date_sent',
                DB::raw("COALESCE(u.name, 'Profesor') as teacher_name")
            )
            ->get()
            ->groupBy('question_id');

        $threads = $questions->map(function ($question) use ($answers) {
            $question->answers = $answers->get($question->id, collect());
            $question->answers_count = $question->answers->count();
            return $question;
        });

        return view('student.messages', [
            'threads' => $threads,
        ]);
    }

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

            return redirect('/contacto')
                ->with('success', '¡Mensaje enviado con éxito!')
                ->with('plausible_events', [
                    ['name' => 'contact_message_sent', 'props' => ['subject' => $affair]]
                ]);
        }

        return redirect('/')->with('error', 'Error al subir la pregunta');
    }
}
