<?php
namespace App\Http\Controllers\Captcha;

use App\Http\Controllers\Controller;
use App\Models\Artiestories;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class captchaesR2 extends Controller
{
    public function captcha1(Request $request){
        $kodeinput = $request->input('kodeinputes');
        $kodecapt = session('captcha_verified');
        if (session('regis')){
            if ($kodeinput === $kodecapt){
                $defaultImage = "defaultuser.png";
                $source = public_path('partses/' . $defaultImage);
                $destinationDir = public_path('users/' . session('username') . '/profil');
                $destination = $destinationDir . '/' . $defaultImage;
                if (!File::exists($destinationDir)) {
                    File::makeDirectory($destinationDir, 0755, true);
                }
                File::copy($source, $destination);
                Users::create([
                    'username' => session('username'),
                    'bio' => session('bio'),
                    'nameuse' => session('nameuse'),
                    'email' => session('email'),
                    'password' => bcrypt(session('password')),
                    'improfil' => session('improfil'),
                ]);
                session()->flush();
                return redirect()->route('authes')->with(['alert' => 'Yey akun mu sudah jadi!', 'form' => 'login']);
            } else {
                return redirect()->route('authes')->with(['alert' => 'Kode salah!', 'form' => 'captcha1']);
            }
        } if (session('forget')){
            if ($kodeinput === $kodecapt){
                return redirect()->route('authes')->with(['alert' => 'Ubah password kamu!', 'form' => 'forget1']);
            }
           else {
                return redirect()->route('authes')->with(['alert' => 'Kode salah!', 'form' => 'captcha1']);
            } 
        } if (session('delete')){
            if ($kodeinput === $kodecapt){
                $user = Users::where('username', session('username'))->firstOrFail();
                $user->deleteaccount = now();
                $user->save();
                return redirect()->route('authes')->with(['alert' => 'Akun kamu berhasil dihapus!', 'form' => 'login']);
            }
            else {
                $pemilik = session('username');
                $referer = $request->headers->get('referer');
                if ($referer && Str::contains($referer, '/profiles/')) {
                    return redirect()->route('profiles.show.withcontent', ['username' => $pemilik])->with(['alert' => 'Kode salah, coba lagi!']);
                } else {
                return redirect()->route('artieses')->with(['alert' => 'Kode salah, coba lagi!']);
                }
            }
        } if (session('deleteistuser')) {
            if ($kodeinput === $kodecapt){
                $reqplat = session('artiestoriesid');
                session(['deleteitsuser1' => true]);
                $story = Artiestories::where('coderies', $reqplat)->first();
                $pemilik = $story?->usericonStories?->username;
                $referer = $request->headers->get('referer');
                if ($referer && Str::contains($referer, '/profiles/')) {
                    return redirect()->route('profiles.show.withcontent', ['username' => $pemilik])->with(['runDelete' => true]);
                } else {
                    return redirect()->to('/Artiestories?GetContent=' . $reqplat)
                        ->with(['runDelete' => true]);
                }
            } else {
                return redirect()->route('authes')->with(['alert' => 'Kode salah!', 'form' => 'captcha1']);
            }
        }
    }
}
