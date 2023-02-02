<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\TeacherService;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Subjects;


class UtilDB extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAllQuarters()
    {
        $quarters = DB::table('quarters')->get();
        return [
            "data" =>  $quarters
        ];
    }
    public function getAllIcons()
    {
        $icons = DB::table('animal_icons')->get();
        return [
            "data" =>  $icons
        ];
    }
   
 

    public function updateQuarter(Request $request,$quarterCode){

        DB::beginTransaction();
        DB::table('quarters')
        ->update(array('status' => ""));

        $update = DB::table('quarters')
        ->where('quarter_code', $quarterCode)
        ->update(array('status' => "ACTIVE"));
        DB::commit();

        if($update){
            return true;
        }else{
            return false;
        }
    }

    public function updateIcons(Request $request){
        $update=DB::table('animal_icons')
        ->where('id', $request->iconId)
        ->update(array('icon' => $request->icon,
                       'color'=> $request->color));

        if($update){
            return true;
        }else{
            return false;
        }

    }

    public function deleteIcon(Request $request){
        $delete=DB::table('animal_icons')
        ->where('id', $request->iconId)->delete();
        if($delete){
            return true;
        }else{
            return false;
        }

    }
    public function deleteSubject(Request $request){
        $delete=DB::table('subjects')
        ->where('subj_code', $request->subject)->delete();
        if($delete){
            return true;
        }else{
            return false;
        }

    }
    public function deleteSection(Request $request){
        $delete=DB::table('school_sections')
        ->where('s_code', $request->section)->delete();
        if($delete){
            return true;
        }else{
            return false;
        }

    }
    public function deleteAnnouncement(Request $request){
        $delete=DB::table('announcement')
        ->where('id', $request->anno)->delete();
        if($delete){
            return true;
        }else{
            return false;
        }

    }
    
    public function deleteStudent(Request $request){
        DB::beginTransaction();
        $deleteUsers=DB::table('users')
        ->where('id', $request->id_number)->delete();

        $deleteHashs=DB::table('hash_tables')
        ->where('hash_id', $request->id_number)->delete();
        
        $deleteStudents=DB::table('sy_students')
        ->where('id_number', $request->id_number)->delete();

        if($deleteUsers && $deleteHashs && $deleteStudents){
            DB::commit();
            return true;
        }else{
            DB::rollBack();
            return false;
        }

    }

    public function addLesson(Request $request){
        if ($request->hasFile('lesson_file')){
            $filenameWithExt = $request->file('lesson_file')->getClientOriginalName();

            Log::info("FileName:".$filenameWithExt);
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('lesson_file')->getClientOriginalExtension();
            $fileNameToStore = $request->lesson.'_'.time().'.'.$extension;
            $file= $request->file("lesson_file")->storeAs('public/lessons',$fileNameToStore);

            Log::info("file:".$file);
            // Log::info("Request:".$request->all());
            $quarter = DB::table('quarters')->where('status','ACTIVE')->first();

            $lesson =DB::table("lesson")->insert([
                'lesson'=>$request->lesson,
                'subj_code'=>$request->subj_code,
                'section_code'=>$request->section_code,
                'file'=>$fileNameToStore,
                'quarter'=>$quarter->quarter_code,
                'uploadedBy'=>Auth::id()
            ]);
            return [
                "message"=>"success"
            ];
        }else{
            return [
                "message"=>"No file chosen"
            ];
        }
    }

    public function getAllLesson(Request $request)
    {
        $lessons = DB::table('lesson')
        ->join('subjects', 'subjects.subj_code', '=', 'lesson.subj_code')
        ->join('school_sections', 'school_sections.s_code', '=', 'lesson.section_code')
        ->where('lesson.quarter',$request->quarter)
        ->get();
        return [
            "data" =>  $lessons
        ];
    }

    public function getAssessments(Request $request)
    {
        $quizez = DB::table('assesment_header')
        ->select('assesment_header.*','subjects.subj_desc','school_sections.s_desc')
        ->join('subjects', 'subjects.subj_code', '=', 'assesment_header.subj_code')
        ->join('school_sections', 'school_sections.s_code', '=', 'assesment_header.section_code')
        ->where([
            ['assesment_header.assesment_type','=',$request->type],
            ['assesment_header.quarter_period','=',$request->quarter],
            ['assesment_header.uploaded_by','=',Auth::id()]
        ])
        ->get();
        return [
            "data" =>  $quizez
        ];
    }

    public function getLessonBySectionCode($sectionCode)
    {
        $lessons = DB::table('lesson')
        ->join('subjects', 'subjects.subj_code', '=', 'lesson.subj_code')
        ->where('lesson.section_code','=',$sectionCode)
        ->get();
        return [
            "data" =>  $lessons
        ];
    }
    public function getLessonBySubjectAndSection(Request $request,$subjectCode,$sectionCode){

        Log::info("User:".$sectionCode." Subject:".$subjectCode);
        $lessons = DB::table('lesson')
        ->where([
            ['section_code','=',$sectionCode],
            ['subj_code','=',$subjectCode],
            ['quarter','=',$request->quarterCode]
            ])
        ->get();
        return [
            "data" =>  $lessons
        ];

    }
    
    public function addAnnouncement(Request $request){
        $add=DB::table('announcement')->insert([
            'announcement_for' => $request->announcement_for,
            'announcement_desc' => $request->announcement_desc
        ]);

        if($add){
            return true;
        }else{
            return false;
        }

    }
     public function addIcon(Request $request){
        $add=DB::table('animal_icons')->insert([
            'icon' => $request->icon,
            'color' => $request->color
        ]);

        if($add){
            return true;
        }else{
            return false;
        }

    }

    public function getAllAnnouncement()
    {
        $announcement = DB::table('announcement')->get();
        return [
            "data" =>  $announcement
        ];
    }
    public function updateAnnouncement(Request $request){
        $add=DB::table('announcement')
        ->where('id', $request->id)
        ->update(array('announcement_for' => $request->announcement_for,
                       'announcement_desc'=> $request->announcement_desc));

        if($add){
            return true;
        }else{
            return false;
        }

    }
    public function getStudentAnnouncement()
    {
        $announcement = DB::table('announcement')
        ->where('announcement_for','Student')
        ->get();
        return [
            "data" =>  $announcement
        ];
    }

    public function getTeacherHandledSubjects(Request $request){

        $subjects = new Subjects();
        Log::info("Request Data:".json_encode($request->all()));
        $arrayData =[];
        $allSubjectsByGradeCode = $subjects->getSubjectsByGradeCode($request->gradeCode);
        foreach($allSubjectsByGradeCode as $obj){
            $data = DB::table('teachers_subjects_section')
                    ->where([
                        ['teacher_id','=',$request->teacherId],
                        ['section_code','=',$request->sectionCode],
                        ['subj_code','=',$obj->subj_code]
                        ])->get();
            Log::info("Count :".json_encode($data));

            if(count($data)>0){
                $obj->status ='selected';
                $obj->section= $data[0]->section_code;
            }else{
                $obj->status ='';
            }
            array_push($arrayData,$obj);
        }

        return [
            "data"=>$arrayData
        ];

    }

    public function getTeacherHandledSubjects2(Request $request){  
        Log::info("Request Data:".json_encode($request->all()));
        $subjects = DB::table('teachers_subjects_section')
            ->join('subjects','subjects.subj_code', '=', 'teachers_subjects_section.subj_code')
            ->where([
                ['teachers_subjects_section.section_code','=',$request->sectionCode],
                ['teachers_subjects_section.teacher_id','=',Auth::id()]
            ])->get();

        return [
            "data"=>$subjects
        ];

    }
    


    public function getTeacherHandledSections(Request $request){
        $handledSection = DB::table('teachers_subjects_section')
            ->select('section_code')
            ->where('teacher_id',$request->teacherId)
            ->groupBy('section_code');

        $section =DB::table('school_sections')
            ->whereIn('s_code',$handledSection)
            ->get();

        return [
            "data"=>$section
        ];

    }

    public function getAllGrades()
    {
        $grades = DB::table('school_grades')->get();
        return [
            "data" =>  $grades
        ];
    }
    public function updatePassword(Request $request){

        $oldPassword= $request->oldPassword;
        $newPassword=$request->newPassword;
        $idNumber=Auth::id();
        Log::info("request:".json_encode($request->all()));

        $currentPass = DB::table('hash_tables')->select('value')->where('hash_id',Auth::id())->get();
        Log::info("old:".$oldPassword);
        Log::info("current:".$currentPass[0]->value);

        if($oldPassword!=$currentPass[0]->value){
            return [
                "message"=>"invalid password"
            ];
        }
        
        DB::beginTransaction();
        $user= User::where('id',$idNumber)->update([
            'password' => Hash::make($newPassword)
        ]);

        $hash=DB::table('hash_tables')
        ->where('hash_id', $idNumber)
        ->update(['value'=>$newPassword]);

        if( !$hash || !$user)
        {
            throw new Exception('invalid changing password!');
        }else{
            DB::commit();
            return true;
        }
    }

    public function saveTeacherSectionSubjects(Request $request){


        $count= DB::table('teachers_subjects_section')
                ->where([
                    ['section_code','=',$request->section_code],
                    ['teacher_id','=',$request->teacherId]])
                ->count();
        if($count>0){
            return [
                "message"=>"The teacher section you are trying to save is already exist"
            ];
        }
        DB::beginTransaction();
        $subjects =json_decode($request->subjects);
        // Log::info("subjects: ".$subjects);
        foreach($subjects as $subject){
                Log::info("subject:".json_encode($subject));
                $insert=DB::table('teachers_subjects_section')
                ->insert([
                    'teacher_id'=>$request->teacherId,
                    'subj_code'=>$subject->subj_code,
                    'section_code'=>$request->section_code,
                    'status'=>'ACTIVE'
                ]);

                if(!$insert){
                    DB::rollBack();
                    return [
                        "message"=>"Failed saving ".json_encode($subject)
                    ];
                }

            }
        DB::commit();
        return true;
    }

    public function getQuizBySectionAndSubject(Request $request,$sectionCode,$subjectCode){
        $quizesArray=[];
        $quizes = DB::table('assesment_header')
                    ->where([
                        ['assesment_type','=','quiz'],
                        ['subj_code','=',$subjectCode],
                        ['section_code','=',$sectionCode],
                        ['quarter_period','=',$request->quarterCode]
                    ])->get();
        foreach($quizes as $quiz){
                $status = DB::table('student_assessment_answer_header')
                        ->select('status','score')
                        ->where([
                            ['student_id','=',Auth::id()],
                            ['assesment_id','=',$quiz->assesment_id],
                        ])->first();
                $quiz->isTaken =false;
                $quiz->score =0;
                if($status!=null){
                    if($status->status=="submitted"){
                        $quiz->isTaken =true;
                        $quiz->studentStatus=$status->status;
                        $quiz->score =$status->score;
                    }else if($status->status=="in-progress"){
                        $quiz->isTaken =false;
                        $quiz->studentStatus =$status->status;
                        $quiz->score =$status->score;
                    }
                }
                
                array_push($quizesArray,$quiz);
        }
        return [
            "data"=>$quizesArray
        ];

    }

    public function getExamsBySectionAndSubject(Request $request,$sectionCode,$subjectCode){
        $examsArray=[];
        $exams = DB::table('assesment_header')
                    ->where([
                        ['assesment_type','=','exam'],
                        ['subj_code','=',$subjectCode],
                        ['section_code','=',$sectionCode],
                        ['quarter_period','=',$request->quarterCode]
                    ])->get();
        foreach($exams as $exam){
                $status = DB::table('student_assessment_answer_header')
                        ->select('status','score')
                        ->where([
                            ['student_id','=',Auth::id()],
                            ['assesment_id','=',$exam->assesment_id],
                        ])->first();
                $exam->isTaken =false;
                $exam->score =0;
                if($status!=null){
                    if($status->status=="submitted"){
                        $quiz->isTaken =true;
                        $quiz->studentStatus=$status->status;
                        $quiz->score =$status->score;
                    }else if($status->status=="in-progress"){
                        $quiz->isTaken =false;
                        $quiz->studentStatus =$status->status;
                        $quiz->score =$status->score;
                    }
                }
                array_push($examsArray,$exam);
        }
        return [
            "data"=>$examsArray
        ];

    }

    public function getActivityBySectionAndSubject($sectionCode,$subjectCode){
        $quizesArray=[];
        $quizes = DB::table('assesment_header')
                    ->where([
                        ['assesment_type','=','activity'],
                        ['subj_code','=',$subjectCode],
                        ['section_code','=',$sectionCode],
                    ])->get();
        foreach($quizes as $quiz){
                $status = DB::table('student_assessment_answer_header')
                        ->select('status','score')
                        ->where([
                            ['student_id','=',Auth::id()],
                            ['assesment_id','=',$quiz->assesment_id],
                        ])->first();
                $quiz->isTaken =false;
                $quiz->score =0;
                if($status!=null){
                    if($status->status=="submitted"){
                        $quiz->isTaken =true;
                        $quiz->studentStatus=$status->status;
                        $quiz->score =$status->score;
                    }else if($status->status=="in-progress"){
                        $quiz->isTaken =false;
                        $quiz->studentStatus =$status->status;
                        $quiz->score =$status->score;
                    }
                }
                array_push($quizesArray,$quiz);
        }
        return [
            "data"=>$quizesArray
        ];

    }

    public function tempAnswer(Request $request){

        Log::info("Request:".json_encode($request->all()));

        $count=DB::table('student_assessment_answer_tmp')
            ->where([
                ['student_id','=',Auth::id()],
                ['assesment_id','=',$request->assesmentId],
                ['number','=',$request->number],
                ['test_type','=',$request->testType]
            ])->count();

        if($request->answer==null){
            $request->answer="";
        }

        if($count>0){
            $exec=DB::table('student_assessment_answer_tmp')
            ->where([
                ['student_id','=',Auth::id()],
                ['assesment_id','=',$request->assesmentId],
                ['number','=',$request->number],
                ['test_type','=',$request->testType]
            ])
            ->update([
                'answer'=>$request->answer,
            ]);
        }else{
            $exec=DB::table('student_assessment_answer_tmp')->insert([
                'student_id'=>Auth::id(),
                'assesment_id'=>$request->assesmentId,
                'number'=>$request->number,
                'test_type'=>$request->testType,
                'answer'=>$request->answer,
            ]);
        }

       
        if($exec){
            return true;
        }else{
            return null;
        }

    }

    public function tempAnswerEnumeration(Request $request){

        Log::info("Request:".json_encode($request->all()));

        $count=DB::table('student_assessment_answer_tmp')
            ->where([
                ['student_id','=',Auth::id()],
                ['assesment_id','=',$request->assesmentId],
                ['number','=',$request->number],
                ['test_type','=',$request->testType]
            ])->count();

        if($request->answer==null){
            $request->answer="";
        }

        if($count>0){
            $exec=DB::table('student_assessment_answer_tmp')
            ->where([
                ['student_id','=',Auth::id()],
                ['assesment_id','=',$request->assesmentId],
                ['number','=',$request->number],
                ['test_type','=',$request->testType]
            ])
            ->update([
                'json_answer'=>json_encode($request->answer),
            ]);
        }else{
            $exec=DB::table('student_assessment_answer_tmp')->insert([
                'student_id'=>Auth::id(),
                'assesment_id'=>$request->assesmentId,
                'number'=>$request->number,
                'test_type'=>$request->testType,
                'json_answer'=>json_encode($request->answer),
            ]);
        }

       
        if($exec){
            return true;
        }else{
            return null;
        }

    }

    public function finalAnswer(Request $request){

        $tempAnswer=DB::table('student_assessment_answer_tmp')
            ->where([
                ['student_id','=',Auth::id()],
                ['assesment_id','=',$request->assesmentId],
            ])->get();
        $getCorrectAnswers =DB::table('assesment_details')
                            ->select('number','answer')
                            ->where('assesment_id',$request->assesmentId)
                            ->get();
       DB::beginTransaction();
       $countScore=0;
       foreach($tempAnswer as $answer){
            $exec=DB::table('student_assessment_answer')->insert([
                'student_id'=>Auth::id(),
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
       Log::info("PointsEach: ".json_encode($request->pointsEach));
       Log::info("CorrectAnswer: ".json_encode($countScore));

       $insert=DB::table('student_assessment_answer_header')
       ->where('assesment_id', $request->assesmentId)
       ->update([
                'status'=>'submitted',
                'score'=> $countScore
            ]);
        if(!$insert){
            DB::rollBack();
            return false;
        }

        $delete=DB::table('student_assessment_answer_tmp')
            ->where([
                ['student_id','=',Auth::id()],
                ['assesment_id','=',$request->assesmentId],
            ])->delete();

        if(!$delete){
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;

    }

    public function select2Icons(Request $request){
            $array =[];
            $icons = DB::table('animal_icons')
            ->where('icon','like','%'.$request->search.'%')->get();

            foreach($icons as $icon){
                $icon->text='<i class="'.$icon->icon.'"></i> - <strong>'.$icon->icon.'</strong>';
                array_push($array,$icon);
            }
            Log::info("array:".json_encode($array));
            return [
                "results"=>$array
            ];
            
    }

    public function generatePassword(Request $request){
        $userId = $request->userId;
        $pwd =Str::random(8);
        
        DB::beginTransaction();
        $updatePass = User::where('id',$userId)->update(['password'=>Hash::make($pwd),'isGeneratedPassword'=>1]);
        if(!$updatePass){
            DB::rollBack();
            return [
                "message"=>"Updating Password Failed"
            ];
        }
        $updateHash = DB::table('hash_tables')->where('hash_id',$userId)->update(['value'=>$pwd]);
        if(!$updateHash){
            DB::rollBack();
            return [
                "message"=>"Updating Password Failed"
            ];
        }

        DB::commit();
        return [
            "result"=>true,
            "value"=> $pwd
        ];
    }

}
