<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolGrades extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_code',
        'grade_desc'
    ];
}
