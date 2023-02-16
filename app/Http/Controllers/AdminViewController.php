<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolSection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminViewController extends Controller
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
    public function manage_teacher()
    {
       
        $section =$this->section->getAll();
        
        
        return view('admin/manage-teacher')
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "active")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminQuarter', "")
        ->with('adminIcons', "")
        ->with('adminGrades', "")
        ->with('adminAnnouncement', "")
        ->with('teacherTemplates',"")
        ->with('sections', $section);
    }

    public function manage_sections()
    {
        return view('admin/manage-sections')
        ->with('adminHome', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminQuarter', "")
        ->with('adminIcons', "")
        ->with('adminGrades', "")
        ->with('adminAnnouncement', "")
        ->with('teacherTemplates',"")
        ->with('adminSections', "active");
    }

    public function manage_students()
    {
       
        $section =$this->section->getAll();
        
        return view('admin/manage-student')
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminSubjects', "")
        ->with('adminQuarter', "")
        ->with('adminIcons', "")
        ->with('adminGrades', "")
        ->with('adminStudent', "active")
        ->with('adminAnnouncement', "")
        ->with('teacherTemplates',"")
        ->with('sections', $section);
    }

    public function manage_subjects()
    {
       
        $section =$this->section->getAll();
        
        return view('admin/manage-subjects')
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminSubjects', "active")
        ->with('adminQuarter', "")
        ->with('adminStudent', "")
        ->with('adminIcons', "")
        ->with('adminGrades', "")
        ->with('adminAnnouncement', "")
        ->with('teacherTemplates',"")
        ->with('sections', $section);
    }
    public function manage_quarter()
    {
               
        return view('admin/manage-quarter')
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminSubjects', "")
        ->with('adminAnnouncement', "")
        ->with('adminIcons', "")
        ->with('adminQuarter', "active")
        ->with('adminGrades', "")
        ->with('adminAnnouncement', "")
        ->with('teacherTemplates',"")
        ->with('adminStudent', "");
    
    }

    public function manage_announcement()
    {
       
        
        return view('admin/manage-announcement')
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminGrades', "")
        ->with('adminIcons', "")
        ->with('adminQuarter', "")
        ->with('teacherTemplates',"")
        ->with('adminAnnouncement', "active");
        }
    public function manage_handled_section(Request $request)
    {
        // $section =$this->section->getAll();
        return view('admin/manage-handled-section')
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "active")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminGrades', "")
        ->with('adminIcons', "")
        ->with('adminQuarter', "")
        ->with('adminAnnouncement', "")
        ->with('teacherTemplates',"")
        ->with('teacherName', $request->name)   
        ->with('teacherId', $request->teacherId);
    }

    public function manage_grades(Request $request)
    {
        
        return view('admin/manage-grades')
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminGrades', "active")
        ->with('adminIcons', "")
        ->with('adminQuarter', "")
        ->with('adminAnnouncement', "")
        ->with('adminIcons', "")
        ->with('teacherTemplates',"")
        ->with('teacherName', $request->name)   
        ->with('teacherId', $request->teacherId);
    }
    public function manage_icons(Request $request)
    {
        
        return view('admin/manage-icons')
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminGrades', "")
        ->with('adminIcons', "active")
        ->with('adminQuarter', "")
        ->with('adminAnnouncement', "")
        ->with('teacherName', $request->name)   
        ->with('teacherTemplates',"")
        ->with('teacherId', $request->teacherId);
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
       return view('admin/student_profile')
        ->with('adminStudent',"active")
        ->with('student',$student)
        ->with('profile',$profile)
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminSubjects', "")
        ->with('adminGrades', "")
        ->with('adminIcons', "")
        ->with('adminQuarter', "")
        ->with('teacherTemplates',"")
        ->with('adminAnnouncement', "");
    }
    
}
