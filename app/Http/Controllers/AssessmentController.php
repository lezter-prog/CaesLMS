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

        // $StudentScore = DB::table('student_assessment_answer_header')
        //                 ->join('assesment_header','assesment_header.assesment_id','=','student_assessment_answer_header.assesment_id')
        //                 ->join('sy_students','sy_students.id_number','=','student_assessment_answer_header.student_id')
        //                 ->join('school_sections','school_sections.s_code','=','sy_students.s_code')
        //                 ->join('subjects','subjects.subj_code','=','assesment_header.subj_code')
        //                 ->where([
        //                     ['student_assessment_answer_header.assesment_id','=',$request->assessmentId]
        //                 ])->get();
        // $scores =  DB::table('sy_students')
        //             ->join('student_assessment_answer_header','student_assessment_answer_header.student_id','=','sy_students.id_number')
        //             ->join('assesment_header','assesment_header.assesment_id','=','student_assessment_answer_header.assesment_id')
        //             ->join('school_sections','school_sections.s_code','=','sy_students.s_code')
        //             ->join('subjects','subjects.subj_code','=','assesment_header.subj_code')
        //             ->where([
        //                 ['student_assessment_answer_header.assesment_id','=',$request->assessmentId],
        //                 ['sy_students.s_code','=','S3']
        //             ])->get();

        $students = DB::table('sy_students')
                    ->join('school_sections','school_sections.s_code','=','sy_students.s_code')
                    ->where('sy_students.s_code',$request->sectionCode)
                    ->get();


        $scoreArray =[];
        foreach($students as $student){
            $score =DB::table('student_assessment_answer_header')
                    ->select('student_assessment_answer_header.score','student_assessment_answer_header.status','subjects.subj_desc')
                    ->join('assesment_header','assesment_header.assesment_id','=','student_assessment_answer_header.assesment_id')
                    ->join('subjects','subjects.subj_code','=','assesment_header.subj_code')
                    ->where([
                        ['student_assessment_answer_header.assesment_id','=',$request->assessmentId],
                        ['student_assessment_answer_header.student_id','=',$student->id_number]
                    ])->first();
            if($score !=null){
                $student->score =$score->score;
                $student->studentStatus=$score->status;
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

    public function closeAssessment(Request $request){
        $assessmentId = $request->assessmentId;
        DB::beginTransaction();

        $inProgressStudents = DB::table('student_assessment_answer_header')
                ->where([
                    ['assesment_id','=',$assessmentId],
                    ['status','=','in-progress']
                ])->get();

        foreach($inProgressStudents as $student){
            $answers =  DB::tables('student_assessment_answer_tmp')
                        ->where([
                            ['student_id','=',$student->student_id],
                            ['assesment_id','=',$assessmentId]
                        ])->get();
            $countScore=0;
            foreach($answers as $answer){
                    $exec=DB::table('student_assessment_answer')->insert([
                        'student_id'=>$answer->student_id,
                        'assesment_id'=>$answer->assesment_id,
                        'number'=>$answer->number,
                        'test_type'=>$answer->test_type,
                        'answer'=>$answer->answer,
                        'json_answer'=>$answer->json_answer
                    ]);
                    if(!$exec){
                        DB::rollBack();
                        return false;
                    }
                    $getCorrectAnswers =DB::table('assesment_details')
                        ->select('number','answer','points_each')
                        ->where([
                            ['assesment_id','=',$answer->assesment_id],
                            ['number','=',$answer->number],
                            ['test_type','=',$answer->test_type],
                            ['answer','=',$answer->answer],
                            ['json_answer','=',$answer->json_answer]
                        ])->first();
                    Log::info("answer: ".json_encode($answer));
                    Log::info("CorrectAnswer: ".json_encode($getCorrectAnswers));
                    if($getCorrectAnswers!=null){
                        $countScore=$countScore+$getCorrectAnswers->points_each;
                    }     

            }

            $updateStatus= DB::table('student_assessment_answer_header')
            ->where([
                ['student_id','=',$student->student_id],
                ['assesment_id','=',$assessmentId]
            ])->update([
                'status'=>'unfinished',
                'score'=> $countScore
            ]);

            if(!$updateStatus){
                DB::rollBack();
                return [
                    "message"=>"Updating Students Status Failed"
                ];
            }
        }
        $updateQuizStatus =DB::table('assesment_header')
        ->where('assesment_id',$assessmentId)
        ->update(['status'=>'CLOSED']);
        if(!$updateQuizStatus){
            DB::rollBack();
                return [
                    "message"=>"Closing Status Failed"
                ];
        }


        DB::commit();
        return [
            "result"=>true,
            "message"=>"Successful"
        ];
    }

    public function removeAssessment($assessmentId){
        DB::beginTransaction();
        $delHeader =DB::table('assesment_header')->where('assesment_id',$assessmentId)->delete();

        if(!$delHeader){
            DB::rollBack();
            return [
                "result"=>false
            ];
        }
        $delDetails =DB::table('assesment_details')->where('assesment_id',$assessmentId)->delete();

        if(!$delDetails){
            DB::rollBack();
            return [
                "result"=>false
            ];
        }

        $count1 = DB::table('student_assessment_answer_header')->where('assesment_id',$assessmentId)->count();
        if($count1 >0){
            $stHeader =DB::table('student_assessment_answer_header')->where('assesment_id',$assessmentId)->delete();

            if(!$stHeader){
                DB::rollBack();
                return [
                    "result"=>false,
                    "message"=>"student_assessment_answer_header, failed to remove"
                ];
            }
        }

        $count2 = DB::table('student_assessment_answer')->where('assesment_id',$assessmentId)->count();
        if($count2 >0){
            $stHeader =DB::table('student_assessment_answer')->where('assesment_id',$assessmentId)->delete();
            if(!$stHeader){
                DB::rollBack();
                return [
                    "result"=>false,
                    "message"=>"student_assessment_answer, failed to remove"
                ];
            }
        }

        DB::commit();
        return [
            "result"=>true
        ];
       
    }
}
