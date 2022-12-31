<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolSection;

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
        ->with('adminAnnouncement', "")
        ->with('sections', $section);
    }

    public function manage_sections()
    {
        return view('admin/manage-sections')
        ->with('adminHome', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminAnnouncement', "")
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
        ->with('adminStudent', "active")
        ->with('adminAnnouncement', "")
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
        ->with('adminStudent', "")
        ->with('adminAnnouncement', "")
        ->with('sections', $section);
    }

    public function manage_announcement()
    {
       
        
        return view('admin/manage-announcement')
        ->with('adminHome', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminAnnouncement', "active");
        }
    
}
