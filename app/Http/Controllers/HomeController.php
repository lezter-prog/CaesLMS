<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
        return view('teacher/home');
    }
    public function adminIndex()
    {
        $profile =DB::table('caes_profile')->get();
        
        return view('admin/home')
        ->with('adminHome', "active")
        ->with('adminTeacher', "")
        ->with('adminSections', "")
        // ->with('adminTeacher', "active")
        ->with("profile",$profile[0]);
    }
}
