<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\StudentService;


class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
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

    public function getAllStudentAccount(){
        $sections = $this->studentService->getAllStudentAccount();
        
        return [
            "data" =>   $sections
        ];
    }

    public function createStudentAccount(Request $request){
        $sections = $this->studentService->createStudentAccount($request);
        return $sections;
    }

    public function updateStudent(Request $request,$idNumber){
        $student = $this->studentService->updateStudent($request,$idNumber);
        return $student;
    }

    public function importStudents(Requuest $request){

       $excel = Excel::import(new UsersImport, request()->file('file'));

    }
    
}
