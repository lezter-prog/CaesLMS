<?php
namespace App\Repository;

use App\Models\SyTeachers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;



class TeacherService
{
    public $teacher;


    function __construct(SyTeachers $teacher) {
	    $this->teacher = $teacher;
    }


    public function getAllTeachers()
    {
        $teachers= $this->teacher->getAllTeachers();
        return $teachers;
    }

    public function createTeacher($request)
    {
        $request->password =Crypt::encryptString(Str::random(8));
        $request->decrypted_pass =Crypt::decryptString($request->password);
        $request->status ="ACTIVE";
        $request->role ="R2";
        return $this->teacher->createTeacher($request);
    }

    public function get($request, $sectionCode){
        return $this->section->updateSection($request,$sectionCode);
    }

    public function updateTeacher($request,$teacherId){
        return $this->teacher->updateTeacher($request,$teacherId);
    }
}