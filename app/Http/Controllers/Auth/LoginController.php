<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        try{
                //logout
                auth()->logout();
            // generate the code
            $code = rand(10000,90000);
            // affect the code to the user
            $user->login_code = $code;
            $user->code_expires_at = Carbon::now()->addMinute(3);
            $user->save();

            // send email
            // Mail::raw("Your login verification code is: $code", function ($message) use ($user) {
            //    $message->to($user->email)->subject('Your Login Verification Code');
            //});

            Mail::send("email.verification_code", [
                "code" => $code
            ], function ($message) use ($user){
                $message->to($user->email)->subject("Login Verification Code");
            });





            // store user id to the session
            $request->session()->put('login.id', $user->id);


            // switch to verification view
            return redirect()->route('verify.code.form');
        }catch(Exception $e){
            //logout
            auth()->logout();

            throw $e;
        }


    }
}
