<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\TeacherService;

class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TeacherService $service)
    {
        $this->service = $service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return [
            "status" => 1,
            "data" => "sample API Return"
        ];
    }

    public function getAllTeachers(){
        $teachers = $this->service->getAllTeachers();
        
        return [
            "data" =>   $teachers
        ];
    }

    public function createTeacher(Request $request){
        $teacher = $this->service->createTeacher($request);
        return $teacher;
    }

    public function updateTeacher(Request $request,$teacherId){
        $teacher = $this->service->updateTeacher($request,$teacherId);
        return $teacher;
    }
    
}
