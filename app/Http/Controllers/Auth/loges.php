<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\PersistentLogin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class loges extends Controller
{

    public function check()
    {
        return session()->has('isLoggedIn') && session('isLoggedIn') === true;
    }
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $user = Users::where('username', $username)
            ->orWhere('email', $username)
            ->first();
        if ($user && Hash::check($password, $user->password)) {
            if ($user->username === "Ini Admin") {
                $requestIp = $request->ip();
                $adminIp = env('ADMIN_IP');
                if ($requestIp !== $adminIp) {
                    return redirect()->route('authes')->with([
                        'alert' => 'Username atau Password salah!',
                        'form' => 'login'
                    ]);
                }
            }
            if ($user->deleteaccount) {
                return redirect()->route('authes')->with([
                    'alert' => 'Akun baru dihapus!',
                    'form' => 'login'
                ]);
            }
            $token = Str::random(60);
            $expiresAt = now()->addYear();
            PersistentLogin::create([
                'userid'    => $user->userid,
                'token'      => hash('sha256', $token), 
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'expires_at' => $expiresAt,
            ]);
            Cookie::queue('remember_token', $token, $expiresAt->diffInMinutes(now()));
            session([
                'isLoggedIn' => true,
                'userid' => $user->userid,
                'username' => $user->username,
                'nameuse' => $user->nameuse,
                'email' => $user->email,
                'improfil' => $user->improfil,
            ]);
            return redirect('/');
        }
        return redirect()->route('authes')->with([
            'alert' => 'Username atau Password salah!',
            'form' => 'login'
        ]);
    }

    public function logout(Request $request)
    {
        $rememberToken = $request->cookie('remember_token');
        if ($rememberToken) {
            PersistentLogin::where('token', hash('sha256', $rememberToken))->delete();
            Cookie::queue(Cookie::forget('remember_token'));
        }
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('authes')->with(['alert' => 'Berhasil logout!', 'form' => 'login']);
    }
    public function logines()
    {
        session()->flush();
        return redirect()->route('authes')->with(['alert' => 'Silahkan login!', 'form' => 'login']);
    }
}
