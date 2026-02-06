<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\QuestionTest;
use App\Models\Registers;
use App\Models\Student;
use App\Models\UserIsAssignedTypes;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $sql = "SELECT COUNT(*) 
            FROM users u 
            JOIN user_is_assigned_types uat ON u.id = uat.user_id 
            JOIN types t ON uat.type_id = t.id 
            WHERE u.active = 1 AND t.type = 'student'";

        $totalStudentsActives = DB::scalar($sql);
        
        $totalQuestions = QuestionTest::count();

        $allStudents = Student::all();
        $studentsApproved = [];
        $counter = 0;

        foreach($allStudents as $student){
            $firstTime = Registers::where('student_id', $student->user_id)
                ->orderBy('exam_id', 'asc')
                ->select('note', 'exam_id') 
                ->first();

            if($firstTime !== null) {
                $studentsApproved[] = $firstTime;
                
                if($firstTime->note >= 27){
                    $counter++;
                }
            }
        }

        $totalIntentos = count($studentsApproved);
        $output = 0;

        if ($totalIntentos > 0) {
            $output = ($counter * 100) / $totalIntentos;
        }
        $output = ceil($output);

        return view('home', compact('totalStudentsActives', 'totalQuestions', 'output'));
    }
}