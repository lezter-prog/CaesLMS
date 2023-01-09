<?php
namespace App\Repository;

use App\Models\SyTeachers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
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

    public function getAllTeachers2($request)
    {
        $result =[];
        $teachers= $this->teacher->getAllTeachers2($request);

        foreach($teachers as $teacher){
            
            array_push($result, (object)[
                'id' => $teacher->user_id,
                'text' => $teacher->name,
        ]);
        }
        return $result;
    }

    public function createTeacher($request)
    {
        $pwd =Str::random(8);
        $request->username =Str::lower($request->first_name).'.'.Str::lower($request->last_name);
        $request->password =Hash::make($pwd);
        $request->decrypted_pass =$pwd;
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