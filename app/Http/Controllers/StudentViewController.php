<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolSection;
use App\Models\Subjects;
use App\Models\SyStudents;
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
        $quarters = DB::table('quarters')->get();

        
        return view('student/handled_subject') 
        ->with('studentHome',"active")
        ->with('sectionCode',$request->section_code)
        ->with('subjectCode',$request->subj_code)
        ->with('subject',$subject)
        ->with('quarters',$quarters)
        ->with('subjects',$subjects);
    }

    public function studentProfile()
    {
       $syStudents = new SyStudents();

       $student =$syStudents::where('id_number',Auth::id())->first();

       $profile = DB::table('students_profile')->where('student_id',Auth::id())->first();
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
        
        return view('student/student_profile')
        ->with('student',$student)
        ->with('profile',$profile)
        ->with('studentHome',"")
        ->with('studentProfile',"active");
    }
    
}
