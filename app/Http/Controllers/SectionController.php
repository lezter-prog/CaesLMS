<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\SectionService;

class SectionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
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

    public function getSections(Request $request, $gradeCode){
        $sections = $this->sectionService->getSectionByGradeCode($gradeCode);
        
        return [
            "data" =>   $sections
        ];
    }

    public function createSection(Request $request){
        $sections = $this->sectionService->createSection($request);
        return $sections;
    }

    public function updateSection(Request $request,$sectionCode){
        $sections = $this->sectionService->updateSection($request,$sectionCode);
        return $sections;
    }
    
}
