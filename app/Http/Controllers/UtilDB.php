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

            $lesson =DB::table("lesson")->insert([
                'lesson'=>$request->lesson,
                'subj_code'=>$request->subj_code,
                'section_code'=>$request->section_code,
                'file'=>$fileNameToStore,
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

    public function getAllLesson()
    {
        $lessons = DB::table('lesson')
        ->join('subjects', 'subjects.subj_code', '=', 'lesson.subj_code')
        ->get();
        return [
            "data" =>  $lessons
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

}
