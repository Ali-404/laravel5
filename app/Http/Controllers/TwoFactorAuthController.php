<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RobThree\Auth\TwoFactorAuth;

class TwoFactorAuthController extends Controller
{

    public function setup2FA()
    {
        $tfa = new TwoFactorAuth('laravel5');
        $user = auth()->user();

        // Generate secret
        $secret = $tfa->createSecret();
        $user->google2fa_secret = $secret;
        $user->save();

        // Generate QR Code
        $qrCodeUrl = $tfa->getQRCodeImageAsDataUri('laravel5 (' . $user->email . ')', $secret);

        return view('2fa.setup', compact('qrCodeUrl', 'secret'));
    }


    public function verify2FA(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);
        $tfa = new TwoFactorAuth('laravel5');

        $user = auth()->user();
        $secret = $user->google2fa_secret;

        if ($tfa->verifyCode($secret, $request->code)) {
            session(['2fa_passed' => true]);
            return redirect('/home')->with('success', '2FA verified!');
        }

        return back()->withErrors(['code' => 'Invalid code']);
    }

}
