<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\SubjectService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class GradesController extends Controller
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
    public function getAllGrades(){
        $grades = DB::table("grades")->get();
        return [
            "data"=>$grades
        ];
    }
    
}
