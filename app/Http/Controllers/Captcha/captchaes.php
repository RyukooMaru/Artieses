<?php

namespace App\Http\Controllers\Captcha;

use App\Http\Controllers\Controller;
use App\Models\Artiekeles;
use App\Models\Artiestories;
use App\Models\Artievides;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class captchaes extends Controller
{
    public function hapuscaptcha(Request $request){
        if (session('regis')) {
            session()->flush();
            return redirect()->route('authes')->with(['alert' => 'Gagal registrasi!', 'form' => 'register']);
        } if (session('forget')) {
            session()->flush();
            return redirect()->route('authes')->with(['alert' => 'Gagal ganti password!', 'form' => 'forget']);
        } if (session('delete')) {
            session()->forget('captcha_verified');
            $referer = $request->headers->get('referer');
            if ($referer && Str::contains($referer, '/profiles/')) {
                return response()->json(['closecaptcha' => true]);
            } else {
                return response()->json(['closecaptcha' => true]);
            }
        } if (session('deleteistuser')) {   
            session()->forget('captcha_verified');
            $referer = $request->headers->get('referer');
            if ($referer && Str::contains($referer, '/profiles/')) {
                return response()->json(['closecaptcha' => true]);
            } else {
                return response()->json(['closecaptcha' => true]);
            }
        }
    }
}