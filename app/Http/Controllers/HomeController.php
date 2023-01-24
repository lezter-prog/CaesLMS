<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SchoolSection;
use App\Models\Subjects;





class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function studentIndex()
    {
        $sub = new Subjects();
        $id =  Auth::id();
        $section = DB::table('sy_students')->select('s_code')->where('id_number',$id)->first();
        Log::info("SectionCode:".json_encode($section->s_code));
        $subjects = $sub->getSubjectsBySection($section->s_code,"");
        Log::info("Subjects:".json_encode($subjects));

        return view('student/home') 
        ->with('studentHome',"active")
        ->with('',"")
        ->with('subjects',$subjects);
    }
    public function teacherIndex()
    {
        $sec = new SchoolSection();
        $id =  Auth::id();

        $sections = $sec->getSectionHandled($id);
        Log::info("Sections: ".json_encode($sections));
        return view('teacher/home')
        ->with('teacherDashboard',"active")
        ->with('teacherAnnouncement',"")
        ->with('teacherLesson',"")
        ->with('sections',$sections);
    }
    public function adminIndex()
    {   
        
        $profile =DB::table('caes_profile')->get();
        
        if(count($profile)){
            return view('admin/home')
            ->with('adminHome', "active")
            ->with('adminTeacher', "")
            ->with('adminSections', "")
            ->with('adminStudent', "")
            ->with('adminSubjects', "")
            ->with('adminQuarter', "")
            ->with('adminAnnouncement', "")
            ->with("profile",$profile[0]);
        }
       
    }
}
