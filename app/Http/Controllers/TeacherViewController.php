<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolSection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


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
        $quarters = DB::table('quarters')->get();
        return view('teacher/manage-quiz')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"active")
        ->with('teacherActivity',"")
        ->with('teacherExam',"")
        ->with('teacherTemplates',"")
        ->with('teacherLesson',"");
    }

    public function manage_activity()
    {
        $quarters = DB::table('quarters')->get();
        return view('teacher/manage-activity')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherExam',"")
        ->with('teacherTemplates',"")
        ->with('teacherActivity',"active")
        ->with('teacherLesson',"");
    }

    public function manage_exam()
    {
        $quarters = DB::table('quarters')->get();
        return view('teacher/manage-exam')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
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
        ->with('teacherTemplates',"")
        ->with('teacherTemplates',"active")
        ->with('teacherExam',"")
        ->with('teacherActivity',"")
        ->with('teacherLesson',"");
    }

}
