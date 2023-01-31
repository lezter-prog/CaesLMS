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

    public function getAllStudentAnswer(Request $request){

        $StudentScore = DB::table('student_assessment_answer_header')
                        ->join('assesment_header','assesment_header.assesment_id','=','student_assessment_answer_header.assesment_id')
                        ->join('sy_students','sy_students.id_number','=','student_assessment_answer_header.student_id')
                        ->join('school_sections','school_sections.s_code','=','sy_students.s_code')
                        ->join('subjects','subjects.subj_code','=','assesment_header.subj_code')
                        ->where([
                            ['student_assessment_answer_header.assesment_id','=',$request->assessmentId]
                        ])->get();
        $scores =  DB::table('sy_students')
                    ->join('student_assessment_answer_header','student_assessment_answer_header.student_id','=','sy_students.id_number')
                    ->join('assesment_header','assesment_header.assesment_id','=','student_assessment_answer_header.assesment_id')
                    ->join('school_sections','school_sections.s_code','=','sy_students.s_code')
                    ->join('subjects','subjects.subj_code','=','assesment_header.subj_code')
                    ->where([
                        ['student_assessment_answer_header.assesment_id','=',$request->assessmentId],
                        ['sy_students.s_code','=','S3']
                    ])->get();

        $students = DB::table('sy_students')
                    ->join('school_sections','school_sections.s_code','=','sy_students.s_code')
                    ->where('sy_students.s_code',$request->sectionCode)
                    ->get();


        $scoreArray =[];
        foreach($students as $student){
            $score =DB::table('student_assessment_answer_header')
                    ->join('assesment_header','assesment_header.assesment_id','=','student_assessment_answer_header.assesment_id')
                    ->join('subjects','subjects.subj_code','=','assesment_header.subj_code')
                    ->where([
                        ['student_assessment_answer_header.assesment_id','=',$request->assessmentId],
                        ['student_assessment_answer_header.student_id','=',$student->id_number]
                    ])->first();
            if($score !=null){
                $student->score =$score->score;
                $student->subj_desc =$score->subj_desc;
            }else{
                $student->score ="";
                $student->subj_desc ="";
            }
            array_push($scoreArray,$student);
        }

        return[
            "data"=>$scoreArray
        ];

    }
}
