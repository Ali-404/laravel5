<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;

class LoginCodeController extends Controller
{
    public function showForm()
    {
        if (!auth()->guest())
        {
            return redirect("/home");
        }
        return view('auth.verify_code');
    }

    public function verifyCode(Request $request)
    {


       try {

           $request->validate([
               'code' => 'required|numeric',
           ]);

           $user = User::find(session('login.id'));

           if (!$user || $user->login_code !== $request->code || Carbon::now()->gt($user->code_expires_at)) {
               return back()->withErrors(['code' => 'Invalid or expired code.']);
           }

           // Clear code and log in
           $user->login_code = null;
           $user->code_expires_at = null;
           $user->save();

           auth()->login($user);

           return redirect("/home");
       }catch(Exception $e){
            auth()->logout();
            return redirect("/login");
       }
    }

    public function resendCode(Request $request)
    {
        $user = User::find(session('login.id'));

        if (!$user) {
            return redirect('/login')->withErrors(['email' => 'Session expired. Please log in again.']);
        }

        // generate the code
        $code = rand(10000,90000);
        // affect the code to the user
        $user->login_code = $code;
        $user->code_expires_at = Carbon::now()->addMinute(3);
        $user->save();

        // send email
        Mail::raw("New login verification code is: $code", function ($message) use ($user) {
            $message->to($user->email)->subject('New Login Verification Code');
        });

        return back()->with('success', 'A new code has been sent to your email.');
    }



}
