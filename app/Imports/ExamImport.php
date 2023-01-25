<?php
namespace App\Imports;

use App\Models\SyStudents;
use App\Models\AssesmentDetails;
use App\Models\HashTable;

use App\Imports\QuizIdentification;
use App\Imports\QuizMultiple;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class ExamImport implements WithMultipleSheets, SkipsUnknownSheets
{

    public function __construct($assId)
    {
        $this->assId = $assId; 
    }
    public function sheets(): array
    {
        return [
            'Multiple Choice' => new QuizMultiple($this->assId,'multiple'),
            'Identification' => new QuizIdentification($this->assId,'identify')
        ];
    }
    
    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }
}