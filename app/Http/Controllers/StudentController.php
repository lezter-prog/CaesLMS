<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as FORMAT;
use App\Repository\StudentService;
use App\Imports\StudentsImport;


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
        $students = $this->studentService->getAllStudentAccount();
        
        return [
            "data" =>   $students
        ];
    }

    public function getStudentsBySection($sectionCode){
        $students = $this->studentService->getStudentsBySection($sectionCode);

        return [
            "data"=> $students
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

    public function importStudents(Request $request){
        if ($request->hasFile('studentFile')){
            // $filenameWithExt = $request->file('studentFile')->getClientOriginalName();

            // Log::info("FileName:".$filenameWithExt);
            // $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // $extension = $request->file('studentFile')->getClientOriginalExtension();
            // $fileNameToStore = $request->lesson.'_'.time().'.'.$extension;
            $file= $request->file("studentFile")->getRealPath();
            Log::info("path:".$file);
            
            $excel = Excel::import(new StudentsImport, $file,FORMAT::XLSX);
            
            return [
                "result"=>true
            ];
        }else{
            return [
                "message"=>"File Not Found"
            ];
        }
       


    }
    
}
