<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SchoolSection;


class PasswordChangeController extends Controller
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
    public function changePassword()
    {     
        return view('auth/change-password')
        ->with('teacherDashboard',"")
        ->with('sectionCode', "")
        ->with('teacherAnnouncement',"")
        ->with('teacherLesson',"")
        ->with('teacherQuiz',"")
        ->with('teacherTemplates',"")
        ->with('teacherActivity',"")
        ->with('teacherExam',"")
        ->with('studentHome',"")
        ->with('adminHome',"")
        ->with('sections', "")
        ->with('adminSections', "")
        ->with('adminTeacher', "")
        ->with('adminStudent', "")
        ->with('adminSubjects', "")
        ->with('adminQuarter', "")
        ->with('adminGrades', "active")
        ->with('adminAnnouncement', "");

    }
}
