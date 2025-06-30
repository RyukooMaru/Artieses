<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;

class registeres extends Controller
{
    public function register(Request $request)
    {
        $username = $request->input('username');
        $nameuse = $request->input('nameuse');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        $defaultImage = "users/" . $username . "/profil/defaultuser.png";
        $existingUser = Users::where('username', $username)->first();
        $existingEmail = Users::where('email', $email)->first();

        if ($existingUser) {
            return redirect()->route('authes')->with(['alert' => 'Username sudah digunakan!', 'form' => 'register']);
        }
        if ($existingEmail) {
            return redirect()->route('authes')->with(['alert' => 'Email sudah digunakan!', 'form' => 'register']);
        }
        if ($password !== $password_confirmation) {
            return redirect()->route('authes')->with(['alert' => 'Password dan Konfirmasi Password tidak cocok!', 'form' => 'register']);
        }
        session([
            'regis' => true,
            'username' => $username,    
            'bio' => 'Hai aku pengguna baru',
            'nameuse' => $nameuse,
            'email' => $email,
            'password' => $password,
            'improfil' => $defaultImage,
        ]);
        return redirect()->route('authes')->with(['alert' => 'Selesaikan captcha terlebih dahulu!', 'form' => 'captcha']);
    }
}
