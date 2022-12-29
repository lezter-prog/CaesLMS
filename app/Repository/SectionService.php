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

    public function getSectionBySectionCode($sectionCode){
        return $this->section->getBySectionCode($sectionCode);
    }

    public function createSection($section)
    {
        $num=1;
        $sec =$this->section::latest()->first();
        if($sec!=null){
            $lastsecCode = $sec->s_code;
            $num= preg_replace('/[^0-9]/', '', $lastsecCode)+1;
        }
       
        $newCode ="S".$num;

        return $this->section::create([
            's_code' => $newCode,
            's_desc' => $section->section_desc,
            'g_code' => $section->grade_code,
            'sy' => $section->school_year,
            'teacher_id'=>$section->teacher_id,
            'status'=>'ACTIVE'
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