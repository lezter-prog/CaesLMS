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


class Enumeration implements ToModel, WithHeadingRow
{

    public function __construct($assId)
    {
        $this->assId = $assId; 
    }
    public function model(array $row)
    {
        Log::info("rows :".print_r($row, true));
        $jsonChoices =explode(',',$row['choices']);
        $jsonAnswer=explode(',',$row['key_answer']);

        Log::info("jsonChoices :".print_r($jsonChoices, true));
        Log::info("jsonAnswer :".print_r($jsonAnswer, true));
        $insert=AssesmentDetails::create([
            'assesment_id'=>"ASS".$this->assId,
            'number'=>$row['number'],
            'question'=>$row['question'],
            'test_type'=> 'enumerate',
            'json_choices'=>json_encode($jsonChoices),
            'json_answer'=>json_encode($jsonAnswer),
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