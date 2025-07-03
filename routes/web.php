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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


use Google\Client as Google_Client;
use Google\Service\Drive as Google_Service_Drive;
use Google\Service\Drive\DriveFile as Google_Service_Drive_DriveFile;


# SPECIALIST EVENT ROUTE
    Route::get('/undefined', function () {
        return response()->json(['message' => 'ignored'], 204);
    });
    Route::post('/enter-typing', [artiestoriescomments::class, 'storeGG'])->name('enter');
    Route::post('/broadcast-typing', [artiestoriescomments::class, 'broadcast'])->name('broadcast');
    Route::post('/enter-typing1', [artiestoriescomments::class, 'storeGG1'])->name('enter1');
    Route::post('/broadcast-typing1', [artiestoriescomments::class, 'broadcast1'])->name('broadcast1');

    Route::get('/konten/{id}', function ($id) {
        try {
            $credentialsPath = base_path(env('GOOGLE_CREDENTIALS_PATH'));

            $client = new Google_Client();
            $client->setAuthConfig($credentialsPath);
            $client->addScope(Google_Service_Drive::DRIVE_READONLY);
            $service = new Google_Service_Drive($client);
            $response = $service->files->get($id, [
                'alt' => 'media'
            ]);
            $meta = $service->files->get($id, ['fields' => 'mimeType, name']);
            return Response::make($response->getBody()->getContents(), 200, [
                'Content-Type' => $meta->mimeType ?? 'application/octet-stream',
                'Content-Disposition' => 'inline; filename="' . $meta->name . '"',
                'Accept-Ranges' => 'bytes',
            ]);
        } catch (\Google_Service_Exception $e) {
            abort(404, 'File tidak ditemukan / akses dibatasi');
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat mengakses file Google Drive');
        }
    });
 #
    // Route::get('/check-limits', function (Request $request) {
    //     return [
    //         'ipadmin' => env('ADMIN_IP'),
    //         'reqip' => $request->ip(),
    //     ];
    // });
    // Route::get('/check-limits-size', function () {
    //     return response()->json([
    //         'upload_max_filesize_php' => ini_get('upload_max_filesize'),
    //         'post_max_size_php' => ini_get('post_max_size'),
    //         'memory_limit_php' => ini_get('memory_limit'),
    //         'max_execution_time_php' => ini_get('max_execution_time'),
    //         'user_ini_filename' => ini_get('user_ini.filename'),
    //     ]);
    // });
    // Route::get('/check-userini', function () {
    //     return response()->json([
    //         'user_ini_filename' => ini_get('user_ini.filename'), 
    //         'user_ini_path' => php_ini_loaded_file(), 
    //         'scan_additional_ini_files' => php_ini_scanned_files(), 
    //     ]);
    // });
    // Route::get('/phpinfo', function () {
    //     phpinfo();
    // });
 #
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
##
