<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Subjects extends Model
{
    use HasFactory;

    protected $fillable = [
        'subj_code',
        'subj_desc',
        'g_code',
        'sy',
        'status'
    ];

    public function getAll()
    {
        return static::all();
    }
    public function getAllSubjects2($request){

        return static::where('subj_desc','like','%'.$request->search.'%')->get();

    }
    public function createSubject($request){

        return static::create([
            "subj_code"=>$request->subj_code,
            "subj_desc"=>$request->subj_desc,
            "g_code"=>$request->g_code,
            "status"=>"ACTIVE",
            "sy"=>$request->sy,
        ]);

    }

    public function getSubjectsByGradeCode($gradeCode){
        Log::info("Model Request log:".json_encode($gradeCode));
        return static::whereIn('g_code',$gradeCode)->get();
    }

    public function updateSubject($request,$subjectCode){
        return static::where('subj_code',$subjectCode)->update($request->all());
    }
}
