<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        // Lógica PHP, queries, includes
        $datos = DB::table('usuarios')->get();
        return view('home', ['datos' => $datos]);
    }
}
