<?php

namespace App\Http\Controllers\Captcha;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Mail\VerifikasiEmail;
use Exception;
use Illuminate\Support\Str;

class captchaesR1 extends Controller
{
    public function RandomImages()
    {
        $path1 = public_path('captcha/gambar1');
        $path2 = public_path('captcha/gambar2');
        $files1 = File::files($path1);
        $files2 = File::files($path2);
        $randomImage1 = $files1[array_rand($files1)]->getFilename();
        $randomImage2 = $files2[array_rand($files2)]->getFilename();
        $rotations = [0, 45, 90, 135, 180, 225, 270];
        $rotation1 = $rotations[array_rand($rotations)];
        do {
            $rotation2 = $rotations[array_rand($rotations)];
        } while ($rotation2 === $rotation1);
        return response()->json([
            'image1' => asset("captcha/gambar1/$randomImage1"),
            'image2' => asset("captcha/gambar2/$randomImage2"),
            'rotation1' => $rotation1,
            'rotation2' => $rotation2
        ]);
    }
    public function captcha(Request $request)
    {
        $emails = session('email');
        $rotasi1 = $request->input('rotasi1');
        $rotasi2 = $request->input('rotasi2');
        if ($rotasi1 == $rotasi2) {
            $randominputes = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            session()->put(['captcha_verified' => $randominputes]);
            try {
                Mail::to($emails)->send(new VerifikasiEmail($randominputes));
                if(session('delete') ){
                    $referer = $request->headers->get('referer');
                    if ($referer && Str::contains($referer, '/profiles/')) {
                        return response()->json(['requireCaptchadone' => true]);
                    } else {
                        return response()->json(['requireCaptchadone' => true]);
                    }
                } if (session('deleteistuser')) {
                    $referer = $request->headers->get('referer');
                    if ($referer && Str::contains($referer, '/profiles/')) {
                        return response()->json(['requireCaptchadone' => true]);
                    } else {
                        return response()->json(['requireCaptchadone' => true]);
                    }
                } else {
                    return redirect()->route('authes')->with(['captchaes' => 'Masukkan kode verifikasi!', 'form' => 'captcha1']);
                }
            } catch (Exception $e) {
                session()->forget('captcha_verified');
                return redirect()->route('authes')->with(['alert' => 'Kesalahan teknis maafkan aku dan coba lagi!', 'form' => 'captcha']);
            }
        } else {
            if (session('deleteistuser')) {
                $referer = $request->headers->get('referer');
                if ($referer && Str::contains($referer, '/profiles/')) {
                    return response()->json(['requireCaptchalose' => true, 'alert' => 'rotasi tidak sesuai']);
                } else {
                    return response()->json(['requireCaptchalose' => true, 'alert' => 'rotasi tidak sesuai']);
                }
            }
            if(session('delete') ){
                $referer = $request->headers->get('referer');
                if ($referer && Str::contains($referer, '/profiles/')) {
                    return response()->json(['requireCaptchalose' => true, 'alert' => 'rotasi tidak sesuai']);
                } else {
                    return response()->json(['requireCaptchalose' => true, 'alert' => 'rotasi tidak sesuai']);
                }
            }
            else {
                return redirect()->route('authes')->with(['alert' => 'Rotasi ga cocok, coba lagi!', 'form' => 'captcha']);
            }
        } 
    }
}
