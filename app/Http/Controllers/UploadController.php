<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Repository\SubjectService;
use App\Imports\QuizMultiple;
use App\Imports\QuizIdentification;
use App\Imports\ExamImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;



class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubjectService $subjects)
    {
        $this->subjectService = $subjects;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function uploadQuiz(Request $request){
        Log::info("Request".json_encode($request->all()));
        DB::beginTransaction();
        
        $filenameWithExt = $request->file('quiz_file')->getClientOriginalName();
        $assesment = DB::table('assesment_header')->latest()->first();
        $quarter = DB::table('quarters')->where('status','ACTIVE')->first();
        Log::info("Assesment:".json_encode($assesment));
        if($assesment !=null){
            $assesmentId=preg_replace('/[^0-9]/', '', $assesment->assesment_id)+1;
        }else{
            $assesmentId=1;
        }

        $endDate = DateTime::createFromFormat('Y-m-d h:i A', $request->endDate);
        // Log::info("endDate:".$endDate);

        $user = DB::table("assesment_header")->insert([
            "assesment_id"=>"ASS".$assesmentId,
            "assesment_desc"=>$request->quizDesc,
            "assesment_type"=>$request->assessmentType,
            "test_type"=>$request->quizType,
            "total_points"=>$request->totalPoints,
            "points_each"=>$request->pointsEach,
            "filename"=>$filenameWithExt,
            "deadline"=>$endDate->format('Y-m-d H:i:s'),
            "subj_code"=>$request->subj_code,
            "section_code"=>$request->section_code,
            "quarter_period"=>$quarter->quarter_code,
            "status"=>"ACTIVE",
            "sy"=>"2022-2023"
        ]);

        if ($request->hasFile('quiz_file')){
            $file= $request->file("quiz_file")->getRealPath();
            Log::info("path:".$file);
            if($request->quizType=="multiple"){
                $excel = Excel::import(new QuizMultiple($assesmentId,$request->quizType), $file);
                if(!$excel){
                    DB::rollBack();
                }
            }else if($request->quizType=="identify"){
                $excel = Excel::import(new QuizIdentification($assesmentId,$request->quizType), $file);
                if(!$excel){
                    DB::rollBack();
                }
            }else{
                return false;
                DB::rollBack();
            }
        }
        DB::commit();

        return[
            "result"=>true
        ];
    }

    public function uploadExam(Request $request){
        Log::info("Request".json_encode($request->all()));
        DB::beginTransaction();
        
        $filenameWithExt = $request->file('exam_file')->getClientOriginalName();
        $assesment = DB::table('assesment_header')->latest()->first();
        $quarter = DB::table('quarters')->where('status','ACTIVE')->first();
        Log::info("Assesment:".json_encode($assesment));
        if($assesment !=null){
            $assesmentId=preg_replace('/[^0-9]/', '', $assesment->assesment_id)+1;
        }else{
            $assesmentId=1;
        }

        $endDate = DateTime::createFromFormat('Y-m-d h:i A', $request->endDate);
        // Log::info("endDate:".$endDate);

        $user = DB::table("assesment_header")->insert([
            "assesment_id"=>"ASS".$assesmentId,
            "assesment_desc"=>$request->examDesc,
            "assesment_type"=>"exam",
            "test_type"=>"exam",
            "total_points"=>$request->totalPoints,
            "points_each"=>$request->pointsEach,
            "filename"=>$filenameWithExt,
            "deadline"=>$endDate->format('Y-m-d H:i:s'),
            "subj_code"=>$request->subj_code,
            "section_code"=>$request->section_code,
            "quarter_period"=>$quarter->quarter_code,
            "status"=>"ACTIVE",
            "sy"=>"2022-2023"
        ]);

        if ($request->hasFile('exam_file')){
            $file= $request->file("exam_file")->getRealPath();
            Log::info("path:".$file);
            $excel = Excel::import(new ExamImport($assesmentId), $file);
            if(!$excel){
                DB::rollBack();
            }
        }
        DB::commit();

        return[
            "result"=>true
        ];
    }

    public function downloadLesson($lessonId){

       $lesson= DB::table('lesson')->where('id',$lessonId)->first();

        return Storage::url('public/lessons/'.$lesson->file);
    }
    
}
