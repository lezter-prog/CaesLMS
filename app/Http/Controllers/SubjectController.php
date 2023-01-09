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
    
    public function getAllSubjects2(Request $request){
        $subjects = $this->subjectService->getAllSubjects2($request);
        $results= [
            "results" =>   $subjects
        ];
        
        return response()->json($results,200)->header('Content-Type', 'application/json');
    }
    public function getSubjectByGradeCode(Request $request){
        Log::info("Request gradeCode: ". json_encode($request->gradeCode));
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
