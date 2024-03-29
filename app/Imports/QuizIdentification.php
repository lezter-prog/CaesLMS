<?php
namespace App\Imports;

use App\Models\SyStudents;
use App\Models\AssesmentDetails;
use App\Models\HashTable;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class QuizIdentification implements ToModel, WithHeadingRow
{

    public function __construct($assId,$testType)
    {
        $this->assId = $assId; 
        $this->testType = $testType; 
    }
    public function model(array $row)
    {
        

        Log::info("rows :".print_r($row, true));
       
        $insert=AssesmentDetails::create([
            'assesment_id'=>"ASS".$this->assId,
            'number'=>$row['number'],
            'question'=>$row['question'],
            'answer'=>$row['key_answer'],
            'test_type'=> $this->testType,
            'points_each'=>$row['points_each']
        ]);

        Log::info("insert status: ".$insert);

        if($insert){
            return $insert;
        }else{
            return null;
        }

    }

    public function headingRow(): int
    {
        return 1;
    }
}