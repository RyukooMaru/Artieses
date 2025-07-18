<?php

namespace App\Http\Controllers\App\artievides;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artievides;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\Http;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Session;

class controllerartievides extends Controller
{
    private function uploadToGoogleDriveWithOAuth($file)
    {
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
                $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                session(['google_token' => $client->getAccessToken()]);
            } else {
                if ($client->isAccessTokenExpired()) {
                    return redirect('/login-google');
                }
            }
        }
        $service = new \Google_Service_Drive($client);
        $mainFolderId = '1dAtghVH4G3rgOoypIkdqUKAh6uslcHIQ';
        $tempName = 'temp_' . time() . '.' . $file->getClientOriginalExtension();
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $tempName,
            'parents' => [$mainFolderId],
        ]);
        $content = file_get_contents($file->getPathname());
        $mimeType = $file->getMimeType();
        $uploadedFile = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id',
        ]);
        $newName = $uploadedFile->id . '.' . $file->getClientOriginalExtension();
        $updateMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $newName
        ]);
        $service->files->update($uploadedFile->id, $updateMetadata);
        $permission = new \Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);
        $service->permissions->create($uploadedFile->id, $permission);

        return $uploadedFile->id;
    }

    public function uploadFile(Request $request)
    {
        if (!AuthHelper::check()) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }
        $judul = $request->input('judul');
        $kseo = $request->input('kseo');
        $lseo = $request->input('lseo');
        $request->validate([
            'video' => 'required|file|mimes:mp4,avi,mov,wmv,mkv,flv,mpeg,3gp',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,svg'
        ]);
        $apiKey = env('GEMINI_API');
        $prompt = 'Anda adalah seorang moderator konten yang cerdas. Tugas Anda adalah menganalisis teks untuk mendeteksi apakah teks tersebut merupakan PENGHINAAN atau SERANGAN PERSONAL yang menggunakan nama binatang. ' .
            'Jika teks hanya menyebut nama binatang tanpa konteks menghina, loloskan saja. ' .
            'Contoh yang harus dianggap toksik (is_toxic: true): "Kamu anjing", "Dasar monyet", "Otak udang". ' .
            'Contoh yang harus dianggap aman (is_toxic: false): "Anjing", "Saya punya kucing", "Monyet makan pisang". ' .
            'Sekarang, analisis teks berikut dan berikan respons HANYA dalam format JSON yang ketat dengan kunci "is_toxic" (boolean) dan "reason" (string). ' .
            'Teksnya adalah: "' . $judul . "dan" . $lseo . '"';
        $response = Http::timeout(120)->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey,
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]
        );
        if ($response->successful()) {
            $geminiResultText = $response->json('candidates.0.content.parts.0.text');
            preg_match('/\{.*\}/s', $geminiResultText, $matches);
            $analysisResult = null;
            if (!empty($matches[0])) {
                $analysisResult = json_decode($matches[0], true);
            }
            if (isset($analysisResult['is_toxic']) && $analysisResult['is_toxic'] == true) {
                return back()->withErrors(['alert' => 'Konten anda mengandung kata kata kasar!']);
            }
        }
        function generateUniqueCodevides($length = 20) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            do {
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[random_int(0, strlen($characters) - 1)];
                }
            } while (Artievides::where('codevides', $randomString)->exists());
        
            return $randomString;
        }
        $randomString = generateUniqueCodevides();
        $video = $request->file('video');
        $thumbnail = $request->file('thumbnail');
        $videoFileId = $this->uploadToGoogleDriveWithOAuth($video);
        $thumbFileId = $this->uploadToGoogleDriveWithOAuth($thumbnail);
        Artievides::create([
            'userid' => session('userid'),
            'codevides' => $randomString,
            'judul' => $judul,
            'lseo' => $lseo,
            'kseo' => $kseo,
            'video' => $videoFileId,
            'thumbnail' => $thumbFileId,
        ]);
        return redirect()->route('artieses')->with(['alert' => 'Artievides mu sudah di publish!']);
    }
}
