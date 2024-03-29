<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    
    protected $redirectTo =RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function authenticated(Request $request, $user){

        $id = Auth::id();
        Log::info("Id: ".$id);
        $token="";
        // $personalToken = DB::table("personal_access_tokens")->where('tokenable_id',$id)->first();
        Log::info("Session: ".session('token'));
        if(session('token')==""){
            $user = User::where('id',$id)->first();
           
            $token=$user->createToken("API TOKEN")->plainTextToken;
            session(['token' =>  $token]);
            
        }
        $caes =DB::table('caes_profile')->first();
        session(['school_year' =>  $caes->school_year]);
        Log::info("school_year: ".session('school_year'));

        return redirect()->intended(RouteServiceProvider::HOME);
        

    }

    public function createToken(Request $request){
        $user = User::where('id',$request->id)->first();
        return [
            "token"=> $user->createToken("API TOKEN")->plainTextToken
        ];
    }

    
   
}
