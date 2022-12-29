<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caes_profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'school_year',
        'school_address',
        'school_type'
    ];
}
