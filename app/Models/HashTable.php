<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class HashTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash_id',
        'value'
    ];

   
}
