<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


use App\Models\User;
use App\Models\HashTable;
use App\Models\SchoolSection;


class SyTeachers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'status',
        'sy',
        'addedBy'
    ];

    public function getAll()
    {
        $all= static::all();

        return $all;
    }

    public function getAllTeachers(){

        $sections = new SchoolSection();
        $role ="R2";
        $all = DB::table('users')
        ->join('sy_teachers', 'users.id', '=', 'sy_teachers.user_id')
        ->where('users.role', $role)
        ->get();

        $arrayData =[];
        
        Log::info("Teachers:".json_encode($all));

        foreach($all as $object){

            // $object->sections =DB::table("teachers_subjects_section")
            // ->select('section_code')
            // ->where('teacher_id',$object->user_id)
            // ->groupBy('section_code')
            // ->get();
            $object->sections = $sections->getSectionHandled($object->user_id);
            array_push($arrayData,$object);
        }
        return $arrayData;
    }

    public function getAllTeachers2($request){

        return static::where('first_name','like','%'.$request->search.'%')->get();

    }

    public function createTeacher($request){
        DB::beginTransaction();
        $user = User::create([
            'name' => $request->first_name.' '.$request->last_name,
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
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sy'=> $request->sy,
            'status'=> $request->status, 
            'addedBy' => 'admin'
        ]);
        // $subjects =$request->subjects;
        // // Log::info("subjects:".json_encode($subjects));
        // foreach($subjects as $subject){
        //     Log::info("subject:".json_encode($subject));
        //     DB::table('teachers_sections')
        //     ->insert([
        //         'teacher_id'=>$user->id,
        //         'section_code'=>$subject,
        //         'status'=>'ACTIVE'
        //     ]);
        // }
        if( !$teacher || !$user)
        {
            DB::rollBack();
            throw new Exception('Student Account not created!');
        }else{
            DB::commit();
            return $request->all();
        }
    
    }
    
    public function updateTeacher($request,$teacherId){
        DB::beginTransaction();
        $email =$request->email;
        if($email!=null){
            $user = User::where("id",$teacherId)->update(['email'=>$email]);
        }
        
        $teacher= static::where('user_id',$teacherId)->update(
            [
                "first_name"=>$request->first_name,
                "last_name"=>$request->last_name
            ]
        );

        DB::table('teachers_subjects_section')
        ->where('teacher_id',$teacherId)
        ->delete();

        $subjects =json_decode($request->subjects,true);
        // Log::info("subjects:".json_encode($subjects));
        foreach($subjects as $subject){
            Log::info("subject:".json_encode($subject));
            DB::table('teachers_subjects_section')
            ->insert([
                'teacher_id'=>$teacherId,
                'subj_code'=>$subject['subj_code'],
                'section_code'=>$subject['s_code'],
                'status'=>'ACTIVE'
            ]);
        }
        if(!$teacher || !$subjects){
            DB::rollBack();
            throw new Exception('Student Account not created!');
        }else{
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
