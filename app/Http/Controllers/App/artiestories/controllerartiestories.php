<?php

namespace App\Http\Controllers\App\artiestories;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artiestories;
use App\Models\ArtiestoriesType;
use getID3;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Http;

class controllerartiestories extends Controller
{
    public function uploadFile(Request $request)
    {
        if (!AuthHelper::check()) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }
        function generateUniqueCodestories($length = 20) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            do {
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[random_int(0, strlen($characters) - 1)];
                }
            } while (Artiestories::where('coderies', $randomString)->exists());
            return $randomString;
        }
        $randomString = generateUniqueCodestories();
        $judul = $request->input('caption');
        $kseo = $request->input('kseo');
        $lseo = $request->input('lseo');
        $request->validate([
            'file.*' => 'required|mimes:mp4,mov,avi,jpeg,jpg,png,gif',
        ]);
        $files = $request->file('file');
        if (!$files || count($files) === 0) {
            return redirect()->route('artieses')->with(['alert' => 'Tidak ada item yang diunggah!']);
        }
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
        $post = Artiestories::create([
            'userid' => session('userid'),
            'coderies' => $randomString,
            'caption' => $judul,
            'lseo' => $lseo,
            'kseo' => $kseo,
        ]);
        $getID3 = new getID3;
        foreach ($files as $file) {
            $info = $getID3->analyze($file->getPathname());
            $duration = $info['playtime_seconds'] ?? 0;
            if ($duration > 61) {
                return back()->withErrors(['alert' => 'Durasi video tidak boleh lebih dari 60 detik!']);
            }
        }
        foreach ($files as $index => $file) {
            $extension = $file->getClientOriginalExtension();
            $googleDriveUrl = $this->uploadToGoogleDrive($file);
            ArtiestoriesType::create([
                'artiestoriesid' => $post->artiestoriesid,
                'konten' => $googleDriveUrl,
                'type' => $extension
            ]);
        }
        return redirect()->route('artieses')->with(['alert' => 'Artiestories mu sudah di publish!']);
    }
    private function uploadToGoogleDrive($file)
    {
        $credentialsPath = base_path(env('GOOGLE_CREDENTIALS_PATH'));
        $mainFolderId = '1dAtghVH4G3rgOoypIkdqUKAh6uslcHIQ';
        $client = new \Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(\Google_Service_Drive::DRIVE);
        $service = new \Google_Service_Drive($client);
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
}
