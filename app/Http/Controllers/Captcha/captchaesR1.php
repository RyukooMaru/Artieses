<?php

namespace App\Http\Controllers\Captcha;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Mail\VerifikasiEmail;
use App\Models\Artiekeles;
use App\Models\Artiestories;
use App\Models\Artievides;
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
                    $pemilik = session('username');
                    $referer = $request->headers->get('referer');
                    if ($referer && Str::contains($referer, '/profiles/')) {
                        return redirect()->route('profiles.show.withcontent', ['username' => $pemilik])->with(['captchaes' => 'Masukkan kode verifikasi!', 'form' => 'captcha1']);
                    } else {
                        return redirect()->route('artieses')->with(['captchaes' => 'Masukkan kode verifikasi!', 'form' => 'captcha1']);
                    }
                } if (session('deleteistuser')) {
                    $reqplat = session('artiestoriesid');
                    session(['open_commentarist' => $reqplat]);
                    $story = Artiestories::where('coderies', $reqplat)->first();
                    $pemilik = $story?->usericonStories?->username;
                    $referer = $request->headers->get('referer');
                    if ($referer && Str::contains($referer, '/profiles/')) {
                        return redirect()->route('profiles.show.withcontent', ['username' => $pemilik]);
                    } else {
                        if (!session('isLoggedIn')) {
                                $videos = Artievides::whereNull('deltime')
                                    ->with('usericonVides')
                                    ->withCount('likeVides')
                                    ->orderByDesc('like_vides_count')
                                    ->orderByDesc('created_at')
                                    ->get();
                            
                                $stories = Artiestories::whereNull('deltime')
                                    ->withCount('reactStories')
                                    ->orderByDesc('react_stories_count')
                                    ->with([
                                        'usericonStories',
                                        'ReactStories',
                                        'comments.replies',
                                        'comments.userComments',
                                        'comments.replies.userBalcom'
                                    ])
                                    ->latest()
                                    ->get();
                            
                                $articles = Artiekeles::latest()->get();
                            
                                $mergedFeed = [];
                                $videoIndex = $storyIndex = $articleIndex = 0;
                            
                                while ($videoIndex < $videos->count() || $storyIndex < $stories->count() || $articleIndex < $articles->count()) {
                                    for ($i = 0; $i < 6 && $videoIndex < $videos->count(); $i++) {
                                        $mergedFeed[] = ['type' => 'video', 'data' => $videos[$videoIndex++]];
                                    }
                            
                                    for ($i = 0; $i < 3 && $storyIndex < $stories->count(); $i++) {
                                        $mergedFeed[] = ['type' => 'story', 'data' => $stories[$storyIndex++]];
                                    }
                            
                                    for ($i = 0; $i < 3 && $articleIndex < $articles->count(); $i++) {
                                        $mergedFeed[] = ['type' => 'article', 'data' => $articles[$articleIndex++]];
                                    }
                                }
                        }
                        if (session('isLoggedIn')) {
                                $videos = Artievides::whereNull('deltime')
                                    ->with('usericonVides')
                                    ->withCount('likeVides')
                                    ->orderByDesc('like_vides_count')
                                    ->orderByDesc('created_at')
                                    ->get();
                            
                                $stories = Artiestories::whereNull('deltime')
                                    ->withCount('reactStories')
                                    ->orderByDesc('react_stories_count')
                                    ->with([
                                        'usericonStories',
                                        'ReactStories',
                                        'comments.replies',
                                        'comments.userComments',
                                        'comments.replies.userBalcom'
                                    ])
                                    ->latest()
                                    ->get();
                                $articles = Artiekeles::latest()->get();
                                $mergedFeed = [];
                                $videoIndex = $storyIndex = $articleIndex = 0;
                                while ($videoIndex < $videos->count() || $storyIndex < $stories->count() || $articleIndex < $articles->count()) {
                                    for ($i = 0; $i < 6 && $videoIndex < $videos->count(); $i++) {
                                        $mergedFeed[] = ['type' => 'video', 'data' => $videos[$videoIndex++]];
                                    }
                            
                                    for ($i = 0; $i < 3 && $storyIndex < $stories->count(); $i++) {
                                        $mergedFeed[] = ['type' => 'story', 'data' => $stories[$storyIndex++]];
                                    }
                            
                                    for ($i = 0; $i < 3 && $articleIndex < $articles->count(); $i++) {
                                        $mergedFeed[] = ['type' => 'article', 'data' => $articles[$articleIndex++]];
                                    }
                                }
                        }
                        return redirect()->to('/Artiestories?GetContent=' . $reqplat)->with('open_commentarist', $reqplat)->with(['captchaes' => 'Masukkan kode verifikasi!', 'form' => 'captcha1']);
                    }
                } else {
                    return redirect()->route('authes')->with(['captchaes' => 'Masukkan kode verifikasi!', 'form' => 'captcha1']);
                }
            } catch (Exception $e) {
                session()->forget('captcha_verified');
                return redirect()->route('authes')->with(['alert' => 'Kesalahan teknis maafkan aku dan coba lagi!', 'form' => 'captcha']);
            }
        } else {
            return redirect()->route('authes')->with(['alert' => 'Rotasi ga cocok, coba lagi!', 'form' => 'captcha']);
        } 
    }
}
