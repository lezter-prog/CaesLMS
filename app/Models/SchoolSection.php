<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_code',
        'section_desc',
        'grade_code',
        'school_year',
        'adviser'
    ];

    public function getAll()
    {
        return static::all();
    }

    public function getByGradeCode($grade_code){
        return static::where('grade_code',$grade_code)->get();
    }

    public function updateSection($request,$sectionCode){
        return static::where('section_code',$sectionCode)->update($request->all());
    }
}
