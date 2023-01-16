<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolSection;
use App\Models\Subjects;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class StudentViewController extends Controller
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
    public function subject(Request $request)
    {
        $sub = new Subjects();
        $id =  Auth::id();
       
        // $section = DB::table('sy_students')->select('s_code')->where('id_number',$id)->first();
        Log::info("SectionCode:".json_encode($request->section_code));
        $subjects = $sub->getSubjectsBySection($request->section_code,$request->subj_code);
        Log::info("Subjects:".json_encode($subjects));

        $subject = $sub::where('subj_code',$request->subj_code)->first();
        
        return view('student/handled_subject') 
        ->with('studentHome',"active")
        ->with('sectionCode',$request->section_code)
        ->with('subjectCode',$request->subj_code)
        ->with('subject',$subject)
        ->with('subjects',$subjects);
    }

    public function manage_sections()
    {
        return view('admin/manage-sections')
        ->with('adminHome', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminSections', "active");
    }

    public function manage_announcement()
    {
       
        
        return view('teacher/manage-announcement')
        ->with('teacherDashboard',"")
        // ->with('sections', $section)
        ->with('teacherAnnouncement',"active");
        }
    
}
