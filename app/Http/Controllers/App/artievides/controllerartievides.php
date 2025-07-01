<?php

namespace App\Http\Controllers\App\artievides;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artievides;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;

class controllerartievides extends Controller
{
    private function uploadToGoogleDriveDirect($file, $finalFileName)
    {
        $credentialsPath = storage_path('app/google/credentials.json');
        $mainFolderId = '1dAtghVH4G3rgOoypIkdqUKAh6uslcHIQ';
        $client = new \Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(\Google_Service_Drive::DRIVE);
        
        $service = new \Google_Service_Drive($client);

        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $finalFileName,
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
        $videoFilename = session('username') . '_video_' . time() . '.' . $video->getClientOriginalExtension();
        $thumbnailFilename = session('username') . '_thumbnail_' . time() . '.' . $thumbnail->getClientOriginalExtension();
        $videoPath = "Video/" . session('username');
        $thumbPath = "Thumbnail/" . session('username');
        $videoFileId = $this->uploadToGoogleDriveDirect($videoPath, $videoFilename);
        $thumbFileId = $this->uploadToGoogleDriveDirect($thumbPath, $thumbnailFilename);
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
