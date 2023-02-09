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
        $role =Auth::user()->role;
        if($role == "R1"){
            $count =DB::table('student_assessment_answer_header')
            ->where([
                ['assesment_id','=',$request->assesmentId],
                ['student_id','=',$id]
                ])->count();
            if($count==0){
                DB::table('student_assessment_answer_header')->insert([
                    'student_id'=>Auth::id(),
                    'assesment_id'=>$request->assesmentId,
                    'status'=>'in-progress'
                ]);
            }
            
        }
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
        ->with("role",$role)
        ->with('assesmentId',$request->assesmentId)
        ->with("sectionCode",$assesmentHeader->section_code)
        ->with("assessmentDESC",$assesmentHeader->assesment_id)
        ->with("subjCode",$assesmentHeader->subj_code)
        ->with('assesmentDetails',$asessmentArray);
    }

    public function assessmentEnumeration(Request $request){

        $id =  Auth::id();
        $role =Auth::user()->role;
        if($role == "R1"){
            $count =DB::table('student_assessment_answer_header')
            ->where([
                ['assesment_id','=',$request->assesmentId],
                ['student_id','=',$id]
                ])->count();
            if($count==0){
                DB::table('student_assessment_answer_header')->insert([
                    'student_id'=>Auth::id(),
                    'assesment_id'=>$request->assesmentId,
                    'status'=>'in-progress'
                ]);
            }
            
        }
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
                ->select('json_answer')
                ->where([
                    ['student_id','=',Auth::id()],
                    ['assesment_id','=',$request->assesmentId],
                    ['number','=',$ass->number]
                ])->first();
            
            $curAnswer =[];
            if($tempAnswer !=null){
                Log::info("TempAnswer:".json_encode($tempAnswer));
                $curAnswer= json_decode($tempAnswer->json_answer);
                
            }
           
            $ass->json_choices  =json_decode($ass->json_choices);
            $arrayChoices = [];
            foreach($ass->json_choices as $object){
                $obj = (object)[];
                if (in_array($object, $curAnswer)) {
                    $obj->selected ="selected";
                    $obj->value =$object;
                }else{
                    $obj->selected ="";
                    $obj->value =$object;
                }
                array_push($arrayChoices,$obj);
            }
            $ass->json_choices =$arrayChoices;
            
        Log::info("Choices:".json_encode($arrayChoices));
        Log::info("assessmentDetail:".json_encode($ass));
        array_push($asessmentArray,$ass);
        }
        
        return view('assesment/enumeration')
        ->with("role",$role)
        ->with('assesmentId',$request->assesmentId)
        ->with("sectionCode",$assesmentHeader->section_code)
        ->with("subjCode",$assesmentHeader->subj_code)
        ->with('assesmentDetails',$asessmentArray);
    }

    public function assessmentIdentify(Request $request){
        $id =  Auth::id();
        $role =Auth::user()->role;
        if($role == "R1"){
            $count =DB::table('student_assessment_answer_header')
            ->where([
                ['assesment_id','=',$request->assesmentId],
                ['student_id','=',$id]
                ])->count();
            if($count==0){
                DB::table('student_assessment_answer_header')->insert([
                    'student_id'=>Auth::id(),
                    'assesment_id'=>$request->assesmentId,
                    'status'=>'in-progress'
                ]);
            }
            
        }
        $asessmentArray=[];
        $answers=DB::table('assesment_details')
                    ->select('answer')
                    ->where([
                        ['assesment_id',$request->assesmentId]
                    ])->inRandomOrder()->get();
        $assesment =DB::table('assesment_details')
                    ->where([
                        ['assesment_id',$request->assesmentId]
                    ])->get();
                        
        $assesmentHeader =DB::table('assesment_header')
                    ->where('assesment_id',$request->assesmentId)->first();           

        Log::info("Assesment:".json_encode($assesment));

        foreach($assesment as $ass){
           
            // array_push($answers,$ass->answer);
            $tempAnswer =DB::table('student_assessment_answer_tmp')
                ->select('answer')
                ->where([
                    ['student_id','=',Auth::id()],
                    ['assesment_id','=',$request->assesmentId],
                    ['number','=',$ass->number]
                ])->first();
            $ass->initialAnswer="";
            if($tempAnswer !=null){
                $ass->initialAnswer = $tempAnswer->answer;
            }
            
            Log::info("assessmentDetail:".json_encode($ass));
        array_push($asessmentArray,$ass);

        }
        
        return view('assesment/identify-assesment')
        ->with("role",$role)
        ->with('assesmentId',$request->assesmentId)
        ->with("sectionCode",$assesmentHeader->section_code)
        ->with("subjCode",$assesmentHeader->subj_code)
        ->with("assessmentAnswers",$answers)
        ->with('assesmentDetails',$asessmentArray);
    }

    public function assessment(Request $request){
        $id =  Auth::id();
        $role =Auth::user()->role;
        if($role == "R1"){
            $count =DB::table('student_assessment_answer_header')
            ->where([
                ['assesment_id','=',$request->assesmentId],
                ['student_id','=',$id]
                ])->count();
            if($count==0){
                DB::table('student_assessment_answer_header')->insert([
                    'student_id'=>Auth::id(),
                    'assesment_id'=>$request->assesmentId,
                    'status'=>'in-progress'
                ]);
            }
            
        }
        $asessmentMultiple=[];
        $asessmentIdentification=[];
        $answers=DB::table('assesment_details')
                    ->select('answer')
                    ->where([
                        ['assesment_id',$request->assesmentId],
                        ['test_type','=','identify']
                    ])->inRandomOrder()->get();
        $assesment =DB::table('assesment_details')
                    ->where([
                        ['assesment_id',$request->assesmentId]
                    ])->get();
                        
        $assesmentHeader =DB::table('assesment_header')
                    ->where('assesment_id',$request->assesmentId)->first();           

        Log::info("Assesment:".json_encode($assesment));

        foreach($assesment as $ass){
           
            if($ass->test_type == "multiple"){
                $tempAnswer =DB::table('student_assessment_answer_tmp')
                ->select('answer')
                ->where([
                    ['student_id','=',Auth::id()],
                    ['assesment_id','=',$request->assesmentId],
                    ['test_type','=','multiple'],
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
                array_push($asessmentMultiple,$ass);

            }else if($ass->test_type == "identify"){
                $tempAnswer =DB::table('student_assessment_answer_tmp')
                ->select('answer')
                ->where([
                    ['student_id','=',Auth::id()],
                    ['assesment_id','=',$request->assesmentId],
                    ['test_type','=','identify'],
                    ['number','=',$ass->number]
                ])->first();
                $ass->initialAnswer="";
                if($tempAnswer !=null){
                    $ass->initialAnswer = $tempAnswer->answer;
                }
                array_push($asessmentIdentification,$ass);
            }
        Log::info("assessmentDetail:".json_encode($ass));
        }
        
        return view('assesment/exam')
        ->with("role",$role)
        ->with('assesmentId',$request->assesmentId)
        ->with("sectionCode",$assesmentHeader->section_code)
        ->with("subjCode",$assesmentHeader->subj_code)
        ->with("assessmentAnswers",$answers)
        ->with("multipleChoice",$asessmentMultiple)
        ->with('identification',$asessmentIdentification);
    }
    public function view_answer(Request $request){
        $asessmentArray=[];
        $assesment =DB::table('assesment_details')
                    ->where([
                        ['assesment_id',$request->assesmentId]
                    ])->get();
                        
        $assesmentHeader =DB::table('assesment_header')
                    ->where('assesment_id',$request->assesmentId)->first();   
        $testType =$assesmentHeader->test_type;
        $studentName = DB::table('sy_students')->select('first_name','last_name')->where('id_number',$request->studentId)->first();

        Log::info("Name:".json_encode($studentName));

        foreach($assesment as $ass){
           
            // array_push($answers,$ass->answer);
            $answers =DB::table('student_assessment_answer')
                ->select('answer','json_answer')
                ->where([
                    ['student_id','=',$request->studentId],
                    ['assesment_id','=',$request->assesmentId],
                    ['number','=',$ass->number],
                    ['test_type','=',$ass->test_type]
                ])->first();
            $checkAnswers = DB::table('assesment_details')
                            ->where([
                                ['assesment_id','=',$request->assesmentId],
                                ['number','=',$ass->number],
                                ['test_type','=',$ass->test_type]
                            ])->first();
            
            $class="";
            if($checkAnswers!=null && $answers !=null){
                if($testType == "enumerate"){
                    Log::info($checkAnswers->json_answer." == ".$answers->json_answer);
                    if($checkAnswers->json_answer == $answers->json_answer){
                        $class="right-answer";
                    }else{
                        $class="wrong-answer";
                    }
                }else{
                    if(strcasecmp($checkAnswers->answer, $answers->answer) == 0){
                        $class="right-answer";
                    }else{
                        $class="wrong-answer";
                    }
                }
                
            }else{
                $class="wrong-answer";
            }

            $ass->class=$class;
            $ass->answers="";
            if($answers !=null){
                $ass->answers = $answers->answer;
                $ass->json_answer = $answers->json_answer;
            }else{
                $ass->answers = "No Answer";
                $ass->json_answer = "No Answer";
            }
            Log::info("assessmentDetail:".json_encode($ass));
        array_push($asessmentArray,$ass);
        }
        
        return view('assesment/view-answer')
            ->with('testType',$testType)
            ->with('assesmentId',$request->assesmentId)
            ->with("sectionCode",$assesmentHeader->section_code)
            ->with("subjCode",$assesmentHeader->subj_code)
            ->with("name",$studentName->first_name." ".$studentName->last_name)
            ->with("assessmentDesc", $assesmentHeader->assesment_desc)
            ->with('assesmentDetails',$asessmentArray);
    }
    
}
