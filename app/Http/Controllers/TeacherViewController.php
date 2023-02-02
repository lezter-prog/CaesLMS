<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolSection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class TeacherViewController extends Controller
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
    public function section(Request $request)
    {
       
        $section =$this->section->getBySectionCode($request->s_code);

        
        Log::info("sectionBySectionCode: ".$section);
        
        return view('teacher/handled_section')
        ->with('teacherDashboard',"active")
        ->with('sectionCode', $request->s_code)
        ->with('teacherAnnouncement',"")
        ->with('teacherLesson',"")
        ->with('teacherActivity',"")
        ->with('teacherExam',"")
        ->with('teacherTemplates',"")
        ->with('teacherQuiz',"")
        ->with('sections', $section);
    }

    public function manage_sections()
    {
        return view('admin/manage-sections')
        ->with('adminHome', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('teacherActivity',"")
        ->with('teacherQuiz',"")
        ->with('teacherTemplates',"")
        ->with('teacherExam',"")
        ->with('adminSections', "active");
    }
    

    public function manage_announcement()
    {
       
        return view('teacher/manage-announcement')
        ->with('teacherDashboard',"")
        // ->with('sections', $section)
        ->with('teacherLesson',"")
        ->with('teacherQuiz',"")
        ->with('teacherActivity',"")
        ->with('teacherTemplates',"")
        ->with('teacherExam',"")
        ->with('teacherAnnouncement',"active");
        }

    public function manage_lesson()
    {
        $quarters = DB::table('quarters')->get();
        return view('teacher/manage-lesson')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherExam',"")
        ->with('teacherTemplates',"")
        ->with('teacherActivity',"")
        ->with('teacherLesson',"active");
        }

    public function manage_quiz()
    {
        $sec = new SchoolSection();
        $quarters = DB::table('quarters')->get();
        $id =  Auth::id();

        $sections = $sec->getSectionHandled($id);
        return view('teacher/manage-quiz')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('sections',$sections)
        ->with('teacherAnnouncement',"")
        ->with('teacherExam',"")
        ->with('teacherQuiz',"active")
        ->with('teacherTemplates',"")
        ->with('teacherActivity',"")
        ->with('teacherLesson',"");
    }

    public function view_students_assessment(Request $request)
    {
        $activityActive ="";
        $quizActive="";
        $examActive="";
        if($request->assessmentType == "quiz"){
            $quizActive = "active";
        }else if($request->assessmentType == "activity"){
            $activityActive = "active";
        }else if($request->assessmentType == "exam"){
            $examActive = "active";
        }

        Log::info("AssessmentId:".$request->assessmentId);
        $assessment = DB::table('assesment_header')
            ->select('assesment_header.*','subjects.subj_desc','school_sections.s_desc')
            ->join('subjects', 'subjects.subj_code', '=', 'assesment_header.subj_code')
            ->join('school_sections', 'school_sections.s_code', '=', 'assesment_header.section_code')
            ->where('assesment_header.assesment_id',$request->assessmentId)
            ->first();
       if($assessment->status=="ACTIVE"){
            $assessment->statusColor ="primary";
       }else{
            $assessment->statusColor ="danger";
       }

        return view('teacher/view-assessment')
        ->with('teacherDashboard',"")
        ->with('assessment',$assessment)
        ->with('assessmentDesc',$assessment->assesment_desc)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',$quizActive)
        ->with('teacherExam',$examActive)
        ->with('teacherActivity',$activityActive)
        ->with('teacherExam',"")
        ->with('teacherTemplates',"")
        ->with('teacherLesson',"");
    }

    public function manage_activity()
    {
        $sec = new SchoolSection();
        $quarters = DB::table('quarters')->get();
        $id =  Auth::id();

        $sections = $sec->getSectionHandled($id);
        return view('teacher/manage-activity')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('sections',$sections)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherExam',"")
        ->with('teacherTemplates',"")
        ->with('teacherActivity',"active")
        ->with('teacherLesson',"");
    }

    public function manage_exam()
    {
        $sec = new SchoolSection();
        $quarters = DB::table('quarters')->get();
        $id =  Auth::id();

        $sections = $sec->getSectionHandled($id);
        return view('teacher/manage-exam')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('sections',$sections)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherExam',"active")
        ->with('teacherTemplates',"")
        ->with('teacherActivity',"")
        ->with('teacherLesson',"");
    }
    public function manage_templates()
    {
        $quarters = DB::table('quarters')->get();
        return view('teacher/manage-templates')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherTemplates',"active")
        ->with('teacherExam',"")
        ->with('teacherActivity',"")
        ->with('teacherLesson',"");
    }

}
