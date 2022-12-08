<?php
namespace App\Repository;

use App\Models\SchoolSection;



class SectionService
{
    public $section;


    function __construct(SchoolSection $section) {
	$this->section = $section;
    }


    public function getSectionByGradeCode($gradeCode)
    {
        return $this->section->getByGradeCode($gradeCode);
    }

    public function createSection($section)
    {
        return $this->section::create([
            'section_code' => $section->section_code,
            'section_desc' => $section->section_desc,
            'grade_code' => $section->grade_code,
            'school_year' => $section->school_year,
            'adviser'=>""
        ]);
    }

    public function updateSection($request, $sectionCode){
        return $this->section->updateSection($request,$sectionCode);

    }



    // public function find($id)
    // {
    //     return $this->section->findUser($id);
    // }


    // public function delete($id)
    // {
    //     return $this->user->deleteUser($id);
    // }
}