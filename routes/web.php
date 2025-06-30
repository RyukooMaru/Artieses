<?php

use App\Http\Controllers\DeleteKonten;
use App\Http\Controllers\Auth\forgetesR1;
use App\Http\Controllers\Auth\forgetesR2;
use App\Http\Controllers\Auth\loges;
use App\Http\Controllers\Auth\registeres;
use App\Http\Controllers\captcha\captchaes;
use App\Http\Controllers\captcha\captchaesR1;
use App\Http\Controllers\captcha\captchaesR2;
use App\Http\Controllers\App\artieses\searcheses;
use App\Http\Controllers\App\artieses\artieses;
use App\Http\Controllers\App\artiekeles\FileController;
use App\Http\Controllers\App\artiestories\artiestoriescomments;
use App\Http\Controllers\App\artiestories\artiestoriesreact;
use App\Http\Controllers\App\artievides\controllerartievides;
use App\Http\Controllers\App\artiestories\controllerartiestories;
use App\Http\Controllers\App\profil\profilcontroller;
use App\Http\Controllers\App\subscribe\subscontroller;
use App\Http\Controllers\nullpage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Artiestories;
use App\Models\Artievides;
use App\Models\Artiekeles;
use App\Models\ComStories;
use App\Models\Users;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

# SPECIALIST EVENT ROUTE
    Route::get('/undefined', function () {
        return response()->json(['message' => 'ignored'], 204);
    });
    Route::post('/enter-typing', [artiestoriescomments::class, 'storeGG'])->name('enter');
    Route::post('/broadcast-typing', [artiestoriescomments::class, 'broadcast'])->name('broadcast');
    Route::post('/enter-typing1', [artiestoriescomments::class, 'storeGG1'])->name('enter1');
    Route::post('/broadcast-typing1', [artiestoriescomments::class, 'broadcast1'])->name('broadcast1');
##

# APP #
    Route::fallback([nullpage::class, 'handle'])->name('null.page');
    Route::post('/searcheses', [searcheses::class, 'Search'])->name('histories');
    Route::post('/searches', [searcheses::class, 'Search'])->name('appes.searches');
    Route::post('/upload-file-artiekeles', [FileController::class, 'uploadFile'])->name('file.upload.artiekeles');
    Route::post('/upload-file-artievides', [controllerartievides::class, 'uploadFile'])->name('file.upload.artievides');
    Route::post('/upload-file-artiestories', [controllerartiestories::class, 'uploadFile'])->name('file.upload.artiestories');
    Route::get('/', [artieses::class, 'Homes1']);
    Route::get('/artieses', [artieses::class, 'Homes1']);
    Route::get('/Artieses', [artieses::class, 'Homes'])->name('artieses');
    Route::get('/load-feed', [artieses::class, 'loadFeed']);
    Route::post('/reaksi', [artiestoriesreact::class, 'store'])->name('uprcm0');
    Route::post('/uprcm0gg', [artiestoriescomments::class, 'storeGG'])->name('uprcm0gg');
    Route::post('/uprcm1gg', [artiestoriescomments::class, 'storeGG1'])->name('ayokirim.komentar');
    Route::post('/addsubs', [subscontroller::class, 'addsubs'])->name('addsubs');
    Route::post('/reaksi3', [artiestoriesreact::class, 'store3'])->name('uprcm2');
    Route::post('/reaksi2', [artiestoriesreact::class, 'store2'])->name('uprcm1');
    Route::post('/cek-login', function () {
    })->name('cek.login');
    Route::get('/refresh-csrf', function () {
        return response()->json(['csrf' => csrf_token()]);
    });
    Route::post('/set-alert-session', function (\Illuminate\Http\Request $request) {
        session()->flash('alert', $request->input('alert'));
        session()->flash('form', $request->input('form'));
        return response()->json(['status' => 'ok']);
    })->name('set.alert.session');
    Route::post('/set-session-delete', function () {
        session(['delete' => true]);
        return response()->json(['success' => true]);
    });
##

## DELETE KONTEN ##
    Route::post('/delete-konten', [DeleteKonten::class, 'delete'])->name('konten.delete');
##

# AUTHENTICATION #
    Route::get('/authes', function () {
        return view('authes.authes');
    })->name('authes');
    Route::post('/login', [loges::class, 'login'])->name('login.action');
    Route::post('/register', [registeres::class, 'register'])->name('register.action');
    Route::post('/forget', [forgetesR1::class, 'forget'])->name('forget.action');
    Route::post('/forget1', [forgetesR2::class, 'forget1'])->name('forget1.action');
    Route::get('/logout', [loges::class, 'logout']);
    Route::get('/logineses', [loges::class, 'logines']);
##

# CAPTCHA #
    Route::post('/captchada', [captchaesR1::class, 'captcha'])->name('captcha.action');
    Route::post('/captcha1', [captchaesR2::class, 'captcha1'])->name('captcha1.action');
    Route::get('/hapus-captcha', [captchaes::class, 'hapuscaptcha'])->name('hapus.captcha');
    Route::get('/get-random-images', [captchaesR1::class, 'RandomImages']);
##

# CHECK LOGIN #
    Route::get('/clartiekeles', [artieses::class, 'clartiekeles']);
    Route::get('/clartievides', [artieses::class, 'clartievides']);
    Route::get('/clartiestories', [artieses::class, 'clartiestories']);
##

# ARTIEPROFILES #
    Route::get('/profiles/{user}/{filename}', function ($user, $filename, Request $request) {
        $reqplat = $request->query('GetContent');
        $possiblePaths = [
            storage_path('app/public/' . $user . '/artievides/' . $reqplat . '/' . $filename),
            storage_path('app/public/' . $user . '/artiethumb/' . $reqplat . '/' . $filename),
            storage_path('app/public/' . $user . '/artiestories/' . $reqplat . '/' . $filename),
            storage_path('app/public/' . $user . '/artiekeles/' . $reqplat . '/' . $filename),
        ];
        $foundPath = null;
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $foundPath = $path;
                break;
            }
        }
        if (!$foundPath) {
            abort(404, 'File not found in any specified locations.');
        }
        return new BinaryFileResponse($foundPath, 200, [
            'Content-Type' => mime_content_type($foundPath),
            'Accept-Ranges' => 'bytes',
        ], true, null, true, true);
    })->where('filename', '.*\.(mp4|webm|ogg|jpg|jpeg|png|svg|gif)$');
    Route::get('/profiles/{username}', [profilcontroller::class, 'show'])->name('profiles.show');
    Route::get('/profiles/{username}/Artiestories', [ProfilController::class, 'show'])->name('profiles.show.withcontent');
    Route::post('/updateusername/{username}', [ProfilController::class, 'updateUsername']);
    Route::post('/updatenameuse/{username}', [ProfilController::class, 'updatenameuse'])->name('nameuse.update');
    Route::post('/updatebio/{username}', [ProfilController::class, 'updateBio'])->name('bio.update');
    Route::post('/updatefoto/{username}', [ProfilController::class, 'updatefoto'])->name('foto.update');
##

# ARTIEKELES #
    Route::get('/artiekeles', function(){
        return view('appes.artiekeles');
    });
##

# ARTIESTORIES #
    Route::get('/artiestories', function(Request $request) {
        $reqplat = $request->query('GetContent');
        return redirect()->to('/Artiestories?GetContent=' . $reqplat)->with('open_commentarist', $reqplat);
    });
    Route::get('/Artiestories', function (Request $request) {
        $reqplat = $request->query('GetContent');
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
        return view('appes.artieses', compact('mergedFeed', 'reqplat'))->with('open_commentarist', $reqplat);
    })->name('artiestories');
    Route::get('/Artiestoriesvideo/{filename}', function ($filename, Request $request) {
        $reqplat = $request->query('GetContent');
        $konten = Artiestories::where('coderies', $reqplat)->firstOrFail();
        $user = $konten->usericonStories->username;
        $path = storage_path('app/public/' . $user . '/artiestories/' . $reqplat . '/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }
        return new BinaryFileResponse($path, 200, [
            'Content-Type' => mime_content_type($path),
            'Accept-Ranges' => 'bytes',
        ], true, null, true, true);
    })->where('filename', '.*\.(mp4|webm|ogg)$');
    Route::get('/Artiestoriesimg/{filename}', function ($filename, Request $request) {
        $reqplat = $request->query('GetContent');
        $konten = Artiestories::where('coderies', $reqplat)->firstOrFail();
        $user = $konten->usericonStories->username;
        $path = storage_path('app/public/' . $user . '/artiestories/' . $reqplat . '/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }
        return new BinaryFileResponse($path, 200, [
            'Content-Type' => mime_content_type($path),
            'Accept-Ranges' => 'bytes',
        ], true, null, true, true);
    })->where('filename', '.*\.(jpg|jpeg|png|svg|gif)$');
    Route::get('/Artiestoriescom/{filename}', function ($filename, Request $request) {
        preg_match('/-(\d+)\.png$/', $filename, $matches);
        $userId = $matches[1] ?? null;
        if (!$userId) {
            abort(404, 'User ID tidak ditemukan dari filename');
        }
        $user = Users::find($userId);
        if (!$user) {
            abort(404, 'User tidak ditemukan');
        }
        $username = $user->username;
        $path = storage_path('app/public/' . $username . '/artiestoriescomments/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path);
    })->where('filename', '.*\.(jpg|jpeg|png|svg|gif)$');
##

# ARTIEVIDES #
    Route::get('/Artievides', function(Request $request) {
        $reqplat = $request->query('GetContent');
        $video = Artievides::where('codevides', $reqplat)->firstOrFail();
        $user = $video->usericonVides;
        $subscriber = $user->subscriber()->latest()->get();
        $views = $video->banyakviewyahemangiyah()->latest()->get();
        $ip = $request->getClientIp();
        $currentUserId = session('userid');
        $isOwner = $currentUserId == $video->userid;
        if (!$isOwner) {
            $alreadyViewed = DB::table('banyakviewyah?emangiyah?')
                ->where('codevides', $reqplat)
                ->where('banyakviewyah?emangiyah?wkwk', $ip)
                ->exists();

            if (!$alreadyViewed) {
                DB::table('banyakviewyah?emangiyah?')->insert([
                    'codevides' => $reqplat,
                    'banyakviewyah?emangiyah?wkwk' => $ip,
                    'created_at' => now(),
                ]);
            }
        }
        return view('appes.artievides.mainvides', compact('reqplat', 'video', 'user', 'subscriber', 'views'));
    });
    Route::get('/artievides', function(Request $request) {
        return redirect('/Artievides?' . http_build_query($request->query()));
    });
    Route::get('/Artievides/{filename}', function ($filename, Request $request) {
        $reqplat = $request->query('GetContent');
        $video = Artievides::where('codevides', $reqplat)->firstOrFail();
        $user = $video->usericonVides->username;
        $path = storage_path('app/public/' . $user . '/artievides/' . $reqplat . '/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }
        return new BinaryFileResponse($path, 200, [
            'Content-Type' => mime_content_type($path),
            'Accept-Ranges' => 'bytes',
        ], true, null, true, true);
    })->where('filename', '.*\.(mp4|webm|ogg)$');
    Route::get('/Artiethumb/{filename}', function ($filename, Request $request) {
        $reqplat = $request->query('GetContent');
        $video = Artievides::where('codevides', $reqplat)->firstOrFail();
        $user = $video->usericonVides->username;
        $path = storage_path('app/public/' . $user . '/artiethumb/' . $reqplat . '/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }
        return new BinaryFileResponse($path, 200, [
            'Content-Type' => mime_content_type($path),
            'Accept-Ranges' => 'bytes',
        ], true, null, true, true);
    })->where('filename', '.*\.(jpg|jpeg|png|svg|gif)$');
##


