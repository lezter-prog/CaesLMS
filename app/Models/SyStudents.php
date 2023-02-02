<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\HashTable;

class SyStudents extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        's_code',
        'g_code',
        'sy',
        'added_by'
    ];

    public function getAll()
    {
        return static::all();
    }

    public function getAllStudentAccount(){
        $role ="R1";
        return DB::table('users')
        ->join('sy_students', 'users.id', '=', 'sy_students.id_number')
        ->join('school_sections','school_sections.s_code','=','sy_students.s_code')
        ->join('school_grades','school_grades.grade_code','=','sy_students.g_code')
        ->join('hash_tables','hash_tables.hash_id','=','users.id')
        ->where('role', $role)
        ->get();
    }
    public function getStudentsBySection($sectionCode){
        return DB::table('sy_students')
        ->where('s_code',$sectionCode)->get();

    }

    public function createStudentAccount($request){
        DB::beginTransaction();
        $user = User::create([
            'name' => $request->fullname,
            'email' => '',
            'username'=> $request->username,
            'password'=> $request->password,
            'role'=> $request->role
        ]);

        $hashtable = HashTable::create([
            'hash_id'=>$user->id,
            'value'=> $request->decrypted_pass
        ]);

        $student = static::create([
            'id_number' => $user->id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => '',
            's_code'=> $request->s_code,
            'g_code'=> $request->g_code,
            'sy'=> $request->sy,
            'added_by' => 'admin'
        ]);


        if( !$student || !$user)
        {
            throw new Exception('Student Account not created!');
        }else{
            DB::commit();
            return $request->all();
        }
    
    }
    
    public function updateStudent($request,$idNumber){
        return static::where('id_number',$idNumber)->update($request->all());

    }

    
}
