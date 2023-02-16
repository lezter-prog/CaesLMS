<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class GenerateScoreSheet implements FromCollection, WithColumnWidths, WithStyles
{

    private $quizLabel;

    public function __construct($schoolYear,$sectionCode,$subjCode)
    {
      $this->sy=$schoolYear;
      $this->section=$sectionCode;
      $this->subj=$subjCode;
      $this->quizLabel =0;
      $this->examLable =0;
    }
    public function collection()
    {
        $allCollection= new Collection([
            ["Score Sheet Report", $this->sy]
        ]);
        $teacher =  DB::table('sy_teachers')->where('user_id',Auth::id())->first();
        $sec =  DB::table('school_sections')->where('s_code',$this->section)->first();
        $subject =  DB::table('subjects')->where('subj_code',$this->subj)->first();

        $allCollection->push(["Teacher",$teacher->first_name." ".$teacher->last_name]);
        $allCollection->push(["Section",$sec->s_desc]);
        $allCollection->push(["Subjects",$subject->subj_desc]);
        $allCollection->push([""]);
        $allCollection->push(["ACTIVITIES"]);

        $students = DB::table('Sy_Students')->where('s_code',$this->section)->get();

        $actiHeadArr = ["Student Name"];
        $activityHeader = DB::table('assesment_header')->where([
            ['uploaded_by','=',Auth::id()],
            ['sy','=',$this->sy],
            ['section_code','=',$this->section],
            ['subj_code','=',$this->subj],
            ['assesment_type','=','activity']
        ])->get();
        foreach($activityHeader as $activity){
            array_push($actiHeadArr,$activity->assesment_desc."-".$activity->quarter_period);
        }
        
        $allCollection->push($actiHeadArr);
        $this->quizLabel = 8;
       
        $quizData =[];
        $examData =[];
        foreach($students as $student){
            $student->fullname =$student->first_name." ".$student->last_name;
            $activityData =[];
            array_push($activityData,$student->fullname);
           
            foreach($activityHeader as $assesment){
                $studentScore =DB::table('student_assessment_answer_header')
                        ->where([
                            ['assesment_id','=',$assesment->assesment_id],
                            ['student_id','=',$student->id_number]
                        ])->first();
                if($studentScore !=null){
                    array_push($activityData,$studentScore->score);
                }else{
                    array_push($activityData,0);
                }
            }
            $allCollection->push($activityData);
            $this->quizLabel++;
        }

        $allCollection->push([""]);
        $allCollection->push(["QUIZ"]);
        $this->examLable=$this->quizLabel+3;

        $quizHeadArr = ["Student Name"];
        $quizHeader = DB::table('assesment_header')->where([
            ['uploaded_by','=',Auth::id()],
            ['sy','=',$this->sy],
            ['section_code','=',$this->section],
            ['subj_code','=',$this->subj],
            ['assesment_type','=','quiz']
        ])->get();
        foreach($quizHeader as $quiz){
            array_push($quizHeadArr,$quiz->assesment_desc."-".$quiz->quarter_period);
        }
        
        $allCollection->push($quizHeadArr);

        foreach($students as $student){
            $student->fullname =$student->first_name." ".$student->last_name;
            $quizData =[];
            array_push($quizData,$student->fullname);
           
            foreach($quizHeader as $assesment){
                $studentScore =DB::table('student_assessment_answer_header')
                        ->where([
                            ['assesment_id','=',$assesment->assesment_id],
                            ['student_id','=',$student->id_number]
                        ])->first();
                if($studentScore !=null){
                    array_push($quizData,$studentScore->score);
                }else{
                    array_push($quizData,0);
                }
            }
            $allCollection->push($quizData);
            $this->examLable++;
        }

        $allCollection->push([""]);
        $allCollection->push(["EXAMS"]);


        $examHeadArr = ["Student Name"];
        $examHeader = DB::table('assesment_header')->where([
            ['uploaded_by','=',Auth::id()],
            ['sy','=',$this->sy],
            ['section_code','=',$this->section],
            ['subj_code','=',$this->subj],
            ['assesment_type','=','exam']
        ])->get();
        foreach($examHeader as $exam){
            array_push($examHeadArr,$exam->assesment_desc."-".$exam->quarter_period);
        }
        
        $allCollection->push($examHeadArr);

        foreach($students as $student){
            $student->fullname =$student->first_name." ".$student->last_name;
            $examData =[];
            array_push($examData,$student->fullname);
           
            foreach($examHeader as $assesment){
                $studentScore =DB::table('student_assessment_answer_header')
                        ->where([
                            ['assesment_id','=',$assesment->assesment_id],
                            ['student_id','=',$student->id_number]
                        ])->first();
                if($studentScore !=null){
                    array_push($examData,$studentScore->score);
                }else{
                    array_push($examData,0);
                }
            }
            $allCollection->push($examData);
        }
        
       

        return $allCollection;


    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 19,    
            'C' => 19, 
            'D' => 19, 
            'E' => 19, 
            'F' => 19,         
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $quizL = $this->quizLabel+1;
        $examL =$this->examLable+1;
        Log::info("QuizzLablesRowCount: ".$this->quizLabel);

        return [
            // Style the first row as bold text.
            'A1'    => ['font' => ['bold' => true]],
            'A2'    => ['font' => ['bold' => true]],
            'A3'    => ['font' => ['bold' => true]],
            'A4'    => ['font' => ['bold' => true]],

            'A6'    => ['font' => ['bold' => true]],
            'A7'    => ['font' => ['bold' => true]],
            'B7'    => ['font' => ['bold' => true]],
            'C7'    => ['font' => ['bold' => true]],
            'D7'    => ['font' => ['bold' => true]],
            'E7'    => ['font' => ['bold' => true]],
            'F7'    => ['font' => ['bold' => true]],
            'A'.$quizL    => ['font' => ['bold' => true]],
            'A'.$quizL+1    => ['font' => ['bold' => true]],
            'B'.$quizL+1    => ['font' => ['bold' => true]],
            'C'.$quizL+1    => ['font' => ['bold' => true]],
            'D'.$quizL+1    => ['font' => ['bold' => true]],
            'E'.$quizL+1    => ['font' => ['bold' => true]],
            'F'.$quizL+1    => ['font' => ['bold' => true]],
            'A'.$examL    => ['font' => ['bold' => true]],
            'A'.$examL+1    => ['font' => ['bold' => true]],
            'B'.$examL+1    => ['font' => ['bold' => true]],
            'C'.$examL+1    => ['font' => ['bold' => true]],
            'D'.$examL+1    => ['font' => ['bold' => true]],
            'E'.$examL+1    => ['font' => ['bold' => true]],
            'F'.$examL+1    => ['font' => ['bold' => true]],
            
            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }
}