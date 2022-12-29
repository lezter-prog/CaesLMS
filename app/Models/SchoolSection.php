<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
    public function getByTeacher($teacher_id){
        return static::where('teacher_id',$teacher_id)->get();
    }

    public function updateSection($request,$sectionCode){
        return static::where('section_code',$sectionCode)->update($request->all());
    }
}
