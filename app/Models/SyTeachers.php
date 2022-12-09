<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class SyTeachers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'handeled_s_code',
        'handeled_g_code',
        'status',
        'sy',
        'addedBy'
    ];

    public function getAll()
    {
        return static::all();
    }

    public function getAllTeachers(){
        $role ="R2";
        return DB::table('users')
        ->leftJoin('sy_teachers', 'users.id', '=', 'sy_teachers.id')
        ->where('role', $role)
        ->get();
    }

    public function createTeacher($request){
        DB::beginTransaction();
        $user = User::create([
            'name' => $request->name,
            'email' => '',
            'username'=> $request->username,
            'password'=> $request->password,
            'role'=> $request->role
        ]);

        $teacher = static::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'sy'=> $request->sy,
            'status'=> $request->status, 
            'addedBy' => 'admin'
        ]);


        if( !$teacher || !$user)
        {
            throw new \Exception('Student Account not created!');
        }else{
            DB::commit();
            return $request->all();
        }
    
    }
    
    public function updateTeacher($request,$teacherId){
        return static::where('user_id',$teacherId)->update($request->all());
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
