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
            $pemilik = session('username');
            $referer = $request->headers->get('referer');
            if ($referer && Str::contains($referer, '/profiles/')) {
                return redirect()->route('profiles.show.withcontent', ['username' => $pemilik]);
            } else {
                return redirect()->route('artieses');
            }
        } if (session('deleteistuser')) {   
            $reqplat = session('artiestoriesid');
            session()->forget('deleteistuser');
            session()->forget('deleteistuser1');
            $story = Artiestories::where('coderies', $reqplat)->first();
            $pemilik = $story?->usericonStories?->username;
            $referer = $request->headers->get('referer');
            if ($referer && Str::contains($referer, '/profiles/')) {
                return redirect()->route('profiles.show.withcontent', ['username' => $pemilik]);
            } else {
                session(['open_commentarist' => $reqplat]);
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
                return redirect()->to('/Artiestories?GetContent=' . $reqplat)->with('open_commentarist', $reqplat);
            }
        }
    }
}