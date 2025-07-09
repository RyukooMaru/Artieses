<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\PersistentLogin;
use App\Models\Users;

class AutoLoginMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('isLoggedIn')) {
            return $next($request);
        }
        $rememberToken = $request->cookie('remember_token');
        if (!$rememberToken) {
            return $next($request);
        }
        $hashedToken = hash('sha256', $rememberToken);
        $persistentLogin = PersistentLogin::where('token', $hashedToken)->where('expires_at', '>', now())->first();
        if ($persistentLogin) {
            $user = Users::find($persistentLogin->userid);
            if ($user) {
                session([
                    'isLoggedIn' => true,
                    'userid'     => $user->userid,
                    'username'   => $user->username,
                    'nameuse'    => $user->nameuse,
                    'email'      => $user->email,
                    'improfil'   => $user->improfil,
                ]);
            }
        }
        return $next($request);
    }
}
