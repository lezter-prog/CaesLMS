<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\SubjectService;
use Illuminate\Support\Facades\Log;


class SubjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SubjectService $subjects)
    {
        $this->subjectService = $subjects;
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

    public function getAllSubjects(){
        $subjects = $this->subjectService->getAllSubjects();
        
        return [
            "data" =>   $subjects
        ];
    }
    public function getSubjectByGradeCode(Request $request){
        Log::info("Request gradeCode: ". $request->gradeCode);
        $subjects = $this->subjectService->getSubjectsByGradeCode($request->gradeCode);
        Log::info("Subjects: ".$subjects);
      
        return [
            "data"=>$subjects
        ];
    }

    public function createSubject(Request $request){
        $subjects = $this->subjectService->createSubject($request);
        return $subjects;
    }

    public function updateSubject(Request $request,$subjectCode){
        $subjects = $this->subjectService->updateSubject($request,$subjectCode);
        return $subjects;
    }
    
}
