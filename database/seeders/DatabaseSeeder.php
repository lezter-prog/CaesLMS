<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SchoolGrades;
use App\Models\Users;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $pass ="12345";

        for( $i=1;$i<=6;$i++){
            SchoolGrades::create([
                'grade_code' => 'G'.$i,
                'grade_desc' => 'Grade '.$i
            ]);
        }

        Users::create([
            'name' =>'Admin',
            'email'=>'admin@admin.com',
            'username'=>'admin',
            'password'=>Hash::make($pass),
            'role' => 'R0'
        ]);

        
    }
}
