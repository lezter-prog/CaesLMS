<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\TeacherService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class UtilDB extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAllQuarters()
    {
        $quarters = DB::table('quarters')->get();
        return [
            "data" =>  $quarters
        ];
    }

    public function updateQuarter(Request $request,$quarterCode){

        DB::beginTransaction();
        DB::table('quarters')
        ->update(array('status' => ""));

        $update = DB::table('quarters')
        ->where('quarter_code', $quarterCode)
        ->update(array('status' => "ACTIVE"));
        DB::commit();

        if($update){
            return true;
        }else{
            return false;
        }
    }

    public function addAnnouncement(Request $request){
        $add=DB::table('announcement')->insert([
            'announcement_for' => $request->announcement_for,
            'announcement_desc' => $request->announcement_desc
        ]);

        if($add){
            return true;
        }else{
            return false;
        }

    }

    public function getAllAnnouncement()
    {
        $announcement = DB::table('announcement')->get();
        return [
            "data" =>  $announcement
        ];
    }
    public function updateAnnouncement(Request $request){
        $add=DB::table('announcement')
        ->where('id', $request->id)
        ->update(array('announcement_for' => $request->announcement_for,
                       'announcement_desc'=> $request->announcement_desc));

        if($add){
            return true;
        }else{
            return false;
        }

    }
    public function getStudentAnnouncement()
    {
        $announcement = DB::table('announcement')
        ->where('announcement_for','Student')
        ->get();
        return [
            "data" =>  $announcement
        ];
    }
}
