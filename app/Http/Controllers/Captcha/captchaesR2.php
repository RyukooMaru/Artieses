<?php
namespace App\Http\Controllers\Captcha;

use App\Http\Controllers\Controller;
use App\Models\Artiestories;
use App\Models\Artievides;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Str;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;

class captchaesR2 extends Controller
{
    private function uploadToGoogleDrive($localPath, $finalFileName)
    {
        $mainFolderId = '1dAtghVH4G3rgOoypIkdqUKAh6uslcHIQ';

        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_OAUTH_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_OAUTH_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_OAUTH_REDIRECT_URI'));
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->setAccessType('offline');

        $token = session('google_token');
        if (!$token) {
            throw new \Exception("User belum login ke Google.");
        }

        $client->setAccessToken($token);

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                session(['google_token' => $client->getAccessToken()]);
            } else {
                throw new \Exception("Token expired dan tidak ada refresh token.");
            }
        }

        $service = new \Google_Service_Drive($client);

        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $finalFileName,
            'parents' => [$mainFolderId],
        ]);

        $content = file_get_contents($localPath);
        $mimeType = mime_content_type($localPath);

        $uploadedFile = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id',
        ]);

        $permission = new \Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);
        $service->permissions->create($uploadedFile->id, $permission);

        return $uploadedFile->id;
    }

    public function captcha1(Request $request){
        $kodeinput = $request->input('kodeinputes');
        $kodecapt = session('captcha_verified');
        if (session('regis')){
            if ($kodeinput === $kodecapt){
                $source = public_path('partses/defaultuser.png');
                $finalFileName = session('username') . '.png';
                $uploadedFileId = $this->uploadToGoogleDrive($source, $finalFileName);
                Users::create([
                    'username' => session('username'),
                    'bio' => session('bio'),
                    'nameuse' => session('nameuse'),
                    'email' => session('email'),
                    'password' => bcrypt(session('password')),
                    'improfil' => $uploadedFileId,
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
                session(['deleteitsuser1' => true]);
                $contentId = null;
                $ownerUsername = null;
                $redirectUrl = '';
                if (session()->has('artiestoriesid')) {
                    $contentId = session('artiestoriesid');
                    $story = Artiestories::where('coderies', $contentId)->first();
                    $ownerUsername = $story?->usericonStories?->username;
                    $redirectUrl = '/Artiestories?GetContent=' . $contentId;
                } elseif (session()->has('artievidesid')) {
                    $contentId = session('artievidesid');
                    $video = Artievides::where('codevides', $contentId)->first();
                    $ownerUsername = $video?->usericonvides?->username; 
                    $redirectUrl = '/Artievides?GetContent=' . $contentId;
                }
                if (!$ownerUsername) {
                    return redirect('/')->with('error', 'Konten yang Anda coba hapus tidak ditemukan.');
                }
                $referer = $request->headers->get('referer');
                if ($referer && Str::contains($referer, '/profiles/')) {
                    return redirect()->route('profiles.show.withcontent', ['username' => $ownerUsername])
                                    ->with(['runDelete' => true]);
                } else {
                    return redirect()->to($redirectUrl)
                                    ->with(['runDelete' => true]);
                }
            } else {
                return redirect()->route('authes')->with(['alert' => 'Kode salah!', 'form' => 'captcha1']);
            }
        }
    }
}
