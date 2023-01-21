<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolSection;
use App\Models\Subjects;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class AssesmentViewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->section= new SchoolSection();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function assesmentMultiple(Request $request)
    {
        $id =  Auth::id();
        $asessmentArray=[];
        $assesment =DB::table('assesment_details')
                    ->where([
                        ['assesment_id',$request->assesmentId]
                    ])->get();  
        $assesmentHeader =DB::table('assesment_header')
                    ->where('assesment_id',$request->assesmentId)->first();           

        Log::info("Assesment:".json_encode($assesment));

        foreach($assesment as $ass){
            $tempAnswer =DB::table('student_assessment_answer_tmp')
                ->select('answer')
                ->where([
                    ['student_id','=',Auth::id()],
                    ['assesment_id','=',$request->assesmentId],
                    ['number','=',$ass->number]
                ])->first();
            $ass->choiceAChecked="";
            $ass->choiceBChecked="";
            $ass->choiceCChecked="";
            $ass->choiceDChecked="";
            if($tempAnswer !=null){
                if($tempAnswer->answer == $ass->choice_A){
                    $ass->choiceAChecked = "checked";
                }else if($tempAnswer->answer == $ass->choice_B){
                    $ass->choiceBChecked = "checked";
                }else if($tempAnswer->answer == $ass->choice_C){
                    $ass->choiceCChecked = "checked";
                }else if($tempAnswer->answer == $ass->choice_D){
                    $ass->choiceDChecked = "checked";
                }
            }
            
            Log::info("assessmentDetail:".json_encode($ass));
        array_push($asessmentArray,$ass);

        }
        
        return view('assesment/multiple-assesment')
        ->with('assesmentId',$request->assesmentId)
        ->with('pointsEach',$assesmentHeader->points_each)
        ->with("sectionCode",$assesmentHeader->section_code)
        ->with("subjCode",$assesmentHeader->subj_code)
        ->with('assesmentDetails',$asessmentArray);
    }
    
}
