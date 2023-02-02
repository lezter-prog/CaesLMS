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



class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $pass ="12345";
       $user= User::create([
            'name' =>'Admin',
            'email'=>'admin@admin.com',
            'username'=>'admin',
            'password'=> Hash::make($pass),
            'role' => 'R0'
        ]);

        HashTable::create([
            'hash_id'=>$user->id,
            'value'=>$pass
        ]);

        
    }
}
