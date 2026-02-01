<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\QuestionTest;

class HomeController extends Controller
{
    public function index(){
        $totalStudentsActives = User::where('type', 'student')
            ->where('active', 1)->count();
        
        $totalQuestions = QuestionTest::count();

        

        return view('home', compact('totalStudentsActives', 'totalQuestions'));

    }
}