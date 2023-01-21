<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\TeacherService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TeacherService $service)
    {
        $this->service = $service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAllQuiz()
    {
        $assesment=DB::table('assesment_header')->where('assesment_type','quiz')->get();
        return [
            "status" => 1,
            "data" => $assesment
        ];
    }

    public function getStudentAnswer(Request $request){

        $StudentScore = DB::table('student_assessment_answer_header')
                        ->where([
                            ['assesment_id','=',$request->assessmentId],
                            ['student_id','=',Auth::id()]
                        ])->first();
                        
        return[
            "data"=>$StudentScore
        ];

    }
}
