<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Repository\SubjectService;
use App\Imports\QuizMultiple;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
        $assesment = DB::table('assesment_header')->latest()->get();
        $quarter = DB::table('quarters')->where('status','ACTIVE')->first();

        if(count($assesment) >0){
            $assesmentId= "ASS".preg_replace('/[0-9]+/', '', $assesment->assesment_id);
        }else{
            $assesmentId="ASS"."1";
        }

        $endDate = DateTime::createFromFormat('Y-m-d h:i A', $request->endDate);
        // Log::info("endDate:".$endDate);

        $user = DB::table("assesment_header")->insert([
            "assesment_id"=>$assesmentId,
            "assesment_desc"=>"",
            "assesment_type"=>"quiz",
            "test_type"=>$request->quizType,
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
                $excel = Excel::import(new QuizMultiple($assesmentId), $file);
                if(!$excel){
                    DB::rollBack();
                }

            }
        }
        DB::commit();

        return[
            "result"=>true
        ];
    }
    
}
