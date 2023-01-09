<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\TeacherService;
use Illuminate\Support\Facades\Log;

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
    public function getAllTeachers2(Request $request){
        $teachers = $this->service->getAllTeachers2($request);
        // Log::info("teachers:".implode($teachers));
        $results= [
            "results" =>   $teachers
        ];
        
        return response()->json($results,200)->header('Content-Type', 'application/json');
    }

    public function createTeacher(Request $request){
        Log::info("request:".$request->subjects);
        $teacher = $this->service->createTeacher($request);
        return $teacher;
    }

    public function updateTeacher(Request $request,$teacherId){
        $teacher = $this->service->updateTeacher($request,$teacherId);
        return $teacher;
    }
    
}
