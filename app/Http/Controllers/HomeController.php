<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SchoolSection;




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
        
        return view('student/home');
    }
    public function teacherIndex()
    {
        $sec = new SchoolSection();
        $id =  Auth::id();

        $sections = $sec->getByTeacher($id);
        return view('teacher/home')
        ->with('teacherDashboard',"active")
        ->with('teacherAnnouncement',"")
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
