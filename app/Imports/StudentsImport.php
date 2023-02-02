<?php
namespace App\Imports;

use App\Models\SyStudents;
use App\Models\User;
use App\Models\HashTable;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class StudentsImport implements ToModel, WithHeadingRow
{
    public function __construct($sectionCode)
    {
        $this->sectionCode = $sectionCode; 
    }
    public function model(array $row)
    {
        

        Log::info("rows :".print_r($row, true));
        $pwd =Str::random(8);
        $fullName =$row['first_name']." ".$row['middle_name']."".$row['last_name'];
        $username =Str::lower(Str::replace(' ','.',$row['first_name'])).".".Str::lower(Str::replace(' ','.',$row['last_name']));
        $section = DB::table('school_sections')->where('s_code',$this->sectionCode)->first();

        DB::beginTransaction();
        $user = User::create([
            'name' => $fullName,
            'email' => '',
            'username'=> $username,
            'password'=> Hash::make($pwd),
            'role'=> "R1",
            'isGeneratedPassword'=>1
        ]);

        $hashtable = HashTable::create([
            'hash_id'=>$user->id,
            'value'=> $pwd
        ]);
        
        $student = SyStudents::create([
            'id_number' => $user->id,
            'first_name' => $row['first_name'],
            'middle_name' => $row['middle_name'],
            'last_name' => $row['last_name'],
            'email' => '',
            's_code'=> $this->sectionCode,
            'g_code'=> $section->g_code,
            'sy'=> '2022-2023',
            'added_by' => 'admin'
        ]);

        if( !$student || !$user)
        {
            throw new Exception('Student Account not created!:'.$fullName);
        }else{
            DB::commit();
            return $student;
        }

    }

    public function headingRow(): int
    {
        return 1;
    }
}