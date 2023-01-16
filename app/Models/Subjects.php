<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



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

    public function getSubjectsBySection($sectionCode,$subj_code){
        $arrayData=[];
        $subjects = DB::table('teachers_subjects_section')
        ->select('teachers_subjects_section.*','subjects.subj_desc','animal_icons.icon','animal_icons.color','school_sections.s_desc','sy_teachers.first_name','sy_teachers.last_name')
        ->join('subjects','subjects.subj_code','=','teachers_subjects_section.subj_code')
        ->join('school_sections','school_sections.s_code','=','teachers_subjects_section.section_code')
        ->join('sy_teachers','sy_teachers.user_id','=','teachers_subjects_section.teacher_id')
        ->join('animal_icons','animal_icons.id','=','subjects.icon')
        ->where('section_code',$sectionCode)->get();
        foreach ($subjects as $subj) {
            if($subj->subj_code == $subj_code){
                $subj->active="active";
            }else{
                $subj->active="";
            }
            array_push($arrayData,$subj);
        }
        return $arrayData;
    }

    public function updateSubject($request,$subjectCode){
        return static::where('subj_code',$subjectCode)->update($request->all());
    }
}
