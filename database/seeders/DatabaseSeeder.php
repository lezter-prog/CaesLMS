<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolGrades;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for( $i=1;$i<=6;$i++){
            SchoolGrades::create([
                'grade_code' => 'G'.$i,
                'grade_desc' => 'Grade '.$i
            ]);
        }

        
    }
}
