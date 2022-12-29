<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use App\Models\User;
use App\Models\HashTable;


class SyTeachers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
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
        ->join('sy_teachers', 'users.id', '=', 'sy_teachers.user_id')
        ->where('users.role', $role)
        ->get();
    }

    public function getAllTeachers2($request){

        return static::where('name','like','%'.$request->search.'%')->get();

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

        $hashtable = HashTable::create([
            'hash_id'=>$user->id,
            'value'=> $request->decrypted_pass
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
        $email =$request->email;
        if($email!=null){
            DB::beginTransaction();
            $user = User::where("id",$teacherId)->update(['email'=>$email]);
        }
        unset($request->email);
        $teacher= static::where('user_id',$teacherId)->update(
            [
                "name"=>$request->name,
                "handled_g_code"=>$request->handled_g_code,
                "handled_s_code"=>$request->handled_s_code,
            ]
        );
        if($email!=null){
            DB::commit();
        }
        return $teacher;

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
