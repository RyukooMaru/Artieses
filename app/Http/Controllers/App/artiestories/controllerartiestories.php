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
            if ($duration > 60) {
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
        $credentialsPath = storage_path('app/google/artieses-464604-ae12a40dadae.json');
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
