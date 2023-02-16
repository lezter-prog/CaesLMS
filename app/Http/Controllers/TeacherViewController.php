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
        ->with('scoreSheets',"")
        ->with('teacherQuiz',"")
        ->with('teacherReports',"")
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
        ->with('scoreSheets',"")
        ->with('teacherReports',"")
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
        ->with('scoreSheets',"")
        ->with('teacherReports',"")
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
        ->with('teacherActivity',""
        ->with('teacherReports',""))
        ->with('scoreSheets',"")
        ->with('teacherLesson',"active");
        }

    public function manage_quiz()
    {
        $sec = new SchoolSection();
        $quarters = DB::table('quarters')->get();
        $id =  Auth::id();

        $casProfile = DB::table('caes_profile')->select('isPreparing','school_year')->first();
        if($casProfile->isPreparing){
            $endProcess = DB::table('process_school_year')->where('teacher_id',Auth::id())->first();
            $endProcess =   $endProcess->quizes_status;
        }else{
            $endProcess = null;
        }
        $sections = $sec->getSectionHandled($id);
        return view('teacher/manage-quiz')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('sections',$sections)
        ->with('caes',$casProfile)
        ->with('endProcess',$endProcess)
        ->with('teacherAnnouncement',"")
        ->with('teacherExam',"")
        ->with('teacherQuiz',"active")
        ->with('teacherTemplates',"")
        ->with('teacherActivity',"")
        ->with('scoreSheets',"")
        ->with('teacherReports',"")
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
       }else if($assessment->status=="CLEARED"){
            $assessment->statusColor ="success";
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
        ->with('scoreSheets',"")
        ->with('teacherReports',"")
        ->with('teacherLesson',"");
    }

    public function manage_activity()
    {
        $sec = new SchoolSection();
        $quarters = DB::table('quarters')->get();
        $id =  Auth::id();

        $casProfile = DB::table('caes_profile')->select('isPreparing','school_year')->first();
        if($casProfile->isPreparing){
            $endProcess = DB::table('process_school_year')->where('teacher_id',Auth::id())->first();
            $endProcess =   $endProcess->activity_status;
        }else{
            $endProcess = null;
        }

        $sections = $sec->getSectionHandled($id);
        return view('teacher/manage-activity')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('sections',$sections)
        ->with('caes',$casProfile)
        ->with('endProcess',$endProcess)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherExam',"")
        ->with('teacherTemplates',"")
        ->with('scoreSheets',"")
        ->with('teacherReports',"")
        ->with('teacherActivity',"active")
        ->with('teacherLesson',"");
    }

    public function manage_exam()
    {
        $sec = new SchoolSection();
        $quarters = DB::table('quarters')->get();
        $id =  Auth::id();
        
        $casProfile = DB::table('caes_profile')->select('isPreparing','school_year')->first();
        if($casProfile->isPreparing){
            $endProcess = DB::table('process_school_year')->where('teacher_id',Auth::id())->first();
            $endProcess =   $endProcess->exams_status;
        }else{
            $endProcess = null;
        }
        $sections = $sec->getSectionHandled($id);
        return view('teacher/manage-exam')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('sections',$sections)
        ->with('caes',$casProfile)
        ->with('endProcess',$endProcess)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherExam',"active")
        ->with('teacherTemplates',"")
        ->with('teacherActivity',"")
        ->with('scoreSheets',"")
        ->with('teacherReports',"")
        ->with('teacherLesson',"");
    }
    public function manage_templates()
    {
        $quarters = DB::table('quarters')->get();

        return view('teacher/manage-templates')
        ->with('role',Auth::user()->role)
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminQuarter', "")
        ->with('adminIcons', "")
        ->with('adminGrades', "")
        ->with('adminAnnouncement', "")
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherTemplates',"active")
        ->with('teacherExam',"")
        ->with('teacherActivity',"")
        ->with('scoreSheets',"")
        ->with('teacherReports',"")
        ->with('teacherLesson',"");
    }

    public function student_profile(Request $request)
    {
       $student =DB::table('sy_students')->where('id_number',$request->studentId)->first();
       $profile = DB::table('students_profile')->where('student_id',$request->studentId)->first();
       if($profile==null){
        $profile = (object)[];
        $profile->age ="";
        $profile->birthdate ="";
        $profile->contact_no ="";
        $profile->guardian ="";
        $profile->guardian_contact_no ="";
        $profile->address ="";
       }else{
        $profile->birthdate=date('Y-m-d', strtotime($profile->birthdate));
       }
       return view('teacher/student_profile')
        ->with('teacherDashboard',"active")
        ->with('student',$student)
        ->with('profile',$profile)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherTemplates',"")
        ->with('teacherExam',"")
        ->with('teacherActivity',"")
        ->with('scoreSheets',"")
        ->with('teacherReports',"")
        ->with('teacherLesson',"");
    }

    public function scoreSheetSections(){
        $sec = new SchoolSection();
        $id =  Auth::id();

        $sections = $sec->getSectionHandled($id);

        return view('teacher/scoresheet/sections')
        ->with('teacherDashboard',"")
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherTemplates',"")
        ->with('teacherExam',"")
        ->with('teacherActivity',"")
        ->with('teacherLesson',"")
        ->with('scoreSheets',"active")
        ->with('teacherReports',"")
        ->with('sections',$sections);
    }

    public function view_score_sheeet(Request $request){
        $sectionCode =$request->section_code;
        $id =  Auth::id();
        $quarters = DB::table('quarters')->get();

        return view('teacher/scoresheet/score_sheet')
        ->with('teacherDashboard',"")
        ->with('quarters',$quarters)
        ->with('sectionCode',$sectionCode)
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherTemplates',"")
        ->with('teacherExam',"")
        ->with('teacherActivity',"")
        ->with('teacherLesson',"")
        ->with('teacherReports',"")
        ->with('scoreSheets',"active");
    }

    public function view_subjects(Request $request){
        $sectionCode = $request->s_code;
        $id =  Auth::id();
        // Log::info("SectionCode:".json_encode($section->s_code));
        $subjects = DB::table('teachers_subjects_section')
                    ->join('subjects','subjects.subj_code','=','teachers_subjects_section.subj_code')
                    ->join('animal_icons','animal_icons.id','=','subjects.icon')
                    ->where([
                        ["teacher_id","=",$id],
                        ["section_code","=",$sectionCode]
                    ])->get();
        Log::info("Subjects:".json_encode($subjects));

        return view('teacher/scoresheet/subjects')
        ->with('teacherDashboard',"")
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherTemplates',"")
        ->with('teacherExam',"")
        ->with('teacherActivity',"")
        ->with('teacherLesson',"")
        ->with('scoreSheets',"active")
        ->with('teacherReports',"")
        ->with('subjects',$subjects);
    }

    public function view_reports(){

        $id =  Auth::id();
        // Log::info("SectionCode:".json_encode($section->s_code));
        $subjects = DB::table('teachers_subjects_section')
                    ->join('subjects','subjects.subj_code','=','teachers_subjects_section.subj_code')
                    ->join('animal_icons','animal_icons.id','=','subjects.icon')
                    ->where([
                        ["teacher_id","=",$id]
                    ])->get();
        $schoolYear =  DB::table('school_year')->get();

        return view('teacher/report')
        ->with('schoolYears',$schoolYear)
        ->with('teacherDashboard',"")
        ->with('teacherAnnouncement',"")
        ->with('teacherQuiz',"")
        ->with('teacherTemplates',"")
        ->with('teacherExam',"")
        ->with('teacherActivity',"")
        ->with('teacherReports',"active")
        ->with('teacherLesson',"")
        ->with('scoreSheets',"")
        ->with('subjects',$subjects);
    }

}
