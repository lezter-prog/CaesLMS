<?php
namespace App\Repository;

use App\Models\SyStudents;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;



class StudentService
{
    public $student;


    function __construct(SyStudents $student) {
	$this->student = $student;
    }


    public function getAllStudentAccount()
    {
        $students= $this->student->getAllStudentAccount();
        return $students;
    }

    public function createStudentAccount($request)
    {
        $request->fullname =Str::upper($request->first_name." ".$request->last_name);
        $request->password =Crypt::encryptString(Str::random(8));
        $request->decrypted_pass =Crypt::decryptString($request->password);
        $request->username =Str::lower($request->first_name).".".Str::lower($request->last_name);
        $request->role ="R1";
        return $this->student->createStudentAccount($request);
    }

    public function get($request, $sectionCode){
        return $this->section->updateSection($request,$sectionCode);
    }

    private function updateStudent($request,$idNumber){
        return $this->student->updateStudent($request,$idNumber);
    }
}