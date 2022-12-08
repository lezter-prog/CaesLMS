<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\User;

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
        ->leftJoin('sy_students', 'users.id', '=', 'sy_students.id_number')
        ->where('role', $role)
        ->get();
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

        $student = static::create([
            'id_number' => $user->id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => '',
            'g_code'=> $request->g_code,
            'sy'=> $request->sy,
            'added_by' => 'admin'
        ]);


        if( !$student || !$user)
        {
            throw new \Exception('Student Account not created!');
        }else{
            DB::commit();
            return $request->all();
        }
    
    }
    
    public function updateStudent($request,$idNumber){
        return static::where('id_number',$idNumber)->update($request->all());

    }

    public function updatePassword($oldPassword, $newPassword,$idNumber){

        $userCount = User::where(
            ['password','=',$oldPassword],
            ['id','=',$idNumber]
            )->count();
        if($userCount>0){
            return User::where('id',$idNumber)->update([
                'password' => $newPassword
            ]);
        }else{
            throw new \Exception('updating Password Failed!');
        }
    }
}
