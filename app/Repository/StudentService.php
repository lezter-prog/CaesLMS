<?php
namespace App\Repository;

use App\Models\SyStudents;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;




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
        $pwd =Str::random(8);
        $request->fullname =Str::upper($request->first_name." ".$request->last_name);
        $request->password =Hash::make($pwd);
        $request->decrypted_pass =$pwd;
        $request->username =Str::lower(Str::replace(' ','.',$request->first_name)).".".Str::lower(Str::replace(' ','.',$request->last_name));
        $request->role ="R1";
        return $this->student->createStudentAccount($request);
    }

    public function getStudentsBySection( $sectionCode){
        return $this->student->getStudentsBySection($sectionCode);
    }

    public function updateStudent($request,$idNumber){
        return $this->student->updateStudent($request,$idNumber);
    }
}