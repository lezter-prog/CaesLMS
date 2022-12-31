<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolGrades;
use App\Models\User;
use App\Models\HashTable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class QuarterSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table("quarters")->insert(
            array('quarter_code'=>'Q1','quarter_desc'=>'First Quarter')
        );
        DB::table("quarters")->insert(
            array('quarter_code'=>'Q2','quarter_desc'=>'Second Quarter')
        );
        DB::table("quarters")->insert(
            array('quarter_code'=>'Q3','quarter_desc'=>'Third Quarter')
        );
        DB::table("quarters")->insert(
            array('quarter_code'=>'Q4','quarter_desc'=>'Fourth Quarter')
        );
    }
}
