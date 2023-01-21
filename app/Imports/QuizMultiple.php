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


class QuizMultiple implements ToModel, WithHeadingRow
{

    public function __construct($assId)
    {
        $this->assId = $assId; 
    }
    public function model(array $row)
    {
        

        Log::info("rows :".print_r($row, true));
       
        $insert=AssesmentDetails::create([
            'assesment_id'=>"ASS".$this->assId,
            'number'=>$row['number'],
            'question'=>$row['question'],
            'choice_A'=>$row['1st_choice'],
            'choice_B'=>$row['2nd_choice'],
            'choice_C'=>$row['3rd_choice'],
            'choice_D'=>$row['4th_choice'],
            'answer'=>$row['key_answer']
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