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

        // Only generate a new secret if the user doesn't already have one
        if (!$user->google2fa_secret) {
            $user->google2fa_secret = $tfa->createSecret();
            $user->save();
        }

        // Generate QR Code based on the *existing* secret
        $qrCodeUrl = $tfa->getQRCodeImageAsDataUri(
            'laravel5 (' . $user->email . ')',
            $user->google2fa_secret
        );

        return view('2fa.setup', [
            'qrCodeUrl' => $qrCodeUrl,
            'secret' => $user->google2fa_secret,
        ]);
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
