<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class AssesmentDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'assesment_id',
            'number',
            'question',
            'choice_A',
            'choice_B',
            'choice_C',
            'choice_D',
            'answer'
    ];

   
}
