<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreateTimetableController extends Controller
{
    public function upload(Request $request){
        try {

            $date = $request->input("date");
            $start_time = $request->input("start_time");
            $end_time = $request->input("end_time");

            DB::table("timetables")->insert([
                "administrator_id" => Auth::id(),    
                "date" => $date,
                "start_time" => $start_time,
                "end_time" => $end_time,
                "created_at" => now(),
                "updated_at"=> now()
            ]);

            return redirect()->back()->with('success', 'Horario creado correctamente');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error al crear el horario');

        }
    }
}
