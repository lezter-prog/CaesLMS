<?php
namespace App\Repository;

use App\Models\Subjects;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;



class SubjectService
{
    public $subjects;

    function __construct(Subjects $subjects) {
	$this->subjects = $subjects;
    }


    public function getAllSubjects()
    {
        $subjects= $this->subjects->getAll();
        return $subjects;
    }

    public function getAllSubjects2($request)
    {
        $result =[];
        $subjects= $this->subjects->getAllSubjects2($request);

        foreach($subjects as $subject){
            
            array_push($result, (object)[
                'id' => $subject->subj_code,
                'text' => $subject->subj_desc,
        ]);
        }
        return $result;
    }

    public function getSubjectsByGradeCode($gradeCode){
        $subjects= $this->subjects->getSubjectsByGradeCode($gradeCode);
        return $subjects;

    }

    public function createSubject($request)
    {
        return $this->subjects->createSubject($request);
    }

    public function updateSubject($request,$subjectCode){
        return $this->subjects->updateSubject($request,$subjectCode);
    }

}