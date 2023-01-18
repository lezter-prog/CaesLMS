<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class SchoolSection extends Model
{
    use HasFactory;

    protected $fillable = [
        's_code',
        's_desc',
        'g_code',
        'sy',
        'status',
        'teacher_id'
    ];

    public function getAll()
    {
        return static::all();
    }

    public function getByGradeCode($grade_code){
        return static::where('g_code',$grade_code)->get();
    }

    public function getBySectionCode($sectionCode){
        return static::where('s_code',$sectionCode)->first();
    }

    public function getAllSection2($request){

        return DB::table("school_sections")
        ->join('school_grades', 'school_grades.grade_code','=', 'school_sections.g_code')
        ->where('school_sections.s_desc','like','%'.$request->search.'%')->get();

    }
    
    public function getByTeacher($teacher_id){
        return DB::table('school_sections')
        ->join('school_grades','school_grades.grade_code','=','school_sections.g_code')
        ->where('teacher_id',$teacher_id)->get();
        // return static::;
    }

    public function updateSection($request,$sectionCode){
        return static::where('s_code',$sectionCode)->update($request->all());
    }

    public function getSectionHandled($teacher_id){
        $sectionCodes= DB::table('teachers_subjects_section')
        ->select('section_code')
        ->where('teacher_id',$teacher_id)
        ->groupBy('section_code');

        return DB::table('school_sections')
        ->join('school_grades', 'school_grades.grade_code','=', 'school_sections.g_code')
        ->whereIn('s_code',$sectionCodes)
        ->get();

        // return DB::table('teachers_subjects_section')
        // ->select('section_code')
        // ->where('teacher_id',$teacher_id)
        // ->groupBy('section_code')
        // ->get();
    }

    
}
