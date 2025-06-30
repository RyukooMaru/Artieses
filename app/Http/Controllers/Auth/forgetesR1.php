<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;

class forgetesR1 extends Controller
{
    public function forget(Request $request)
    {
        $usernameemail = $request->input('usemail');
        $existingUser = Users::where('username', $usernameemail)->orwhere('email', $usernameemail)->first();
        if ($existingUser) {
            session([
                'forget' => true,
                'usernameemail' => $usernameemail,
                'email' => $existingUser->email,
            ]);
            return redirect()->route('authes')->with(['alert' => 'Selesaikan captcha terlebih dahulu!', 'form' => 'captcha']);
        }
        return redirect()->route('authes')->with(['alert' => 'Username atau Email tidak ketemu!', 'form' => 'forget']);
    }
}
