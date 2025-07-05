<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
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

    public function logout()
    {
        session()->flush();
        return redirect()->route('authes')->with(['alert' => 'Berhasil logout!', 'form' => 'login']);
    }
    public function logines()
    {
        session()->flush();
        return redirect()->route('authes')->with(['alert' => 'Silahkan login!', 'form' => 'login']);
    }
}
