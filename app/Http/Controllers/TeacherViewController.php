<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolSection;
use Illuminate\Support\Facades\Log;


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
        ->with('sections', $section);
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
