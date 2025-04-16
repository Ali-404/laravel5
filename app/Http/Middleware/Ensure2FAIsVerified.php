<?php

namespace App\Http\Middleware;

use Closure;

class Ensure2FAIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session('2fa_passed')) {
            return redirect()->route('2fa.setup');
        }

        return $next($request);
    }

}
