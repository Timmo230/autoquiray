<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrearClassController extends Controller
{
    public function get(Request $request){
        $query = DB::table('timetables');

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('start_time')) {
            $query->where('start_time', '>=', $request->start_time);
        }

        if ($request->filled('end_time')) {
            $query->where('end_time', '<=', $request->end_time);
        }

        $limit = $request->filled('limit') ? min((int)$request->limit, 100) : 20;

        $timetables = $query
            ->where('date','>=', now())
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit($limit)
            ->get()
            ->toArray();

        return view('teacher.createClasses', compact('timetables'));
    }

    public function upload(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'max_students' => 'required|integer|min:1',
            'timetable_id' => 'required'
        ]);

        try {
            DB::table('classes')->insert([
                'title' => $request->title,
                'max_students' => $request->max_students,
                'timetable_id' => $request->timetable_id,
                'teacher_id' => auth()->id(),
                'created_at' => now(),
                'updated_at'=> now()
            ]);

            return redirect()->back()->with('success', 'Clase asignada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al asignar la clase');
        }
    }
}
