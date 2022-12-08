<?php

namespace App\Http\Controllers;
use App\Providers\RouteServiceProvider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Caes_profile;
use Illuminate\Support\Facades\Log;
class ProfileController extends Controller
{
    //

    public function getProfile(){
        // $blogs = ::latest()->paginate(10);
        $profile =DB::table('caes_profile')->get();


        return  $profile;

    }


    public function fileupload(Request $request){
        $request->validate([
            'file' => 'required|mimes:png|max:2048',
        ]);
        $fileName = "logo".'.'.$request->file->extension(); 

        $request->file->move(public_path('uploads'), $fileName);

    
        return back()
                ->with('success','You have successfully upload file.')
                ->with('file', $fileName);
    }
}
