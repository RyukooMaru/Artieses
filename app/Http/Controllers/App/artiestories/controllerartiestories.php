<?php

namespace App\Http\Controllers\App\artiestories;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artiestories;
use App\Models\ArtiestoriesIMG;
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
            $filename = session('username') . '_' . date('Ymd_His') . '_' . $index . '.' . $extension;
            $pathgoogle = session('username') . "/artiestories/" . $randomString;
            $googleDriveUrl = $this->uploadToGoogleDrive($file, $filename, $pathgoogle);
            ArtiestoriesIMG::create([
                'artiestoriesid' => $post->artiestoriesid,
                'konten' => $googleDriveUrl,
            ]);
        }
        return redirect()->route('artieses')->with(['alert' => 'Artiestories mu sudah di publish!']);
    }
    private function createDriveFolder($service, $folderName, $parentId)
    {
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => [$parentId]
        ]);

        $folder = $service->files->create($fileMetadata, [
            'fields' => 'id'
        ]);

        return $folder->id;
    }
    private function findOrCreateFolder($service, $folderName, $parentId)
    {
        $query = sprintf(
            "mimeType='application/vnd.google-apps.folder' and name='%s' and '%s' in parents and trashed=false",
            addslashes($folderName),
            $parentId
        );
        $response = $service->files->listFiles([
            'q' => $query,
            'spaces' => 'drive',
            'fields' => 'files(id, name)',
            'pageSize' => 1,
        ]);
        if (count($response->files) > 0) {
            return $response->files[0]->id;
        }
        return $this->createDriveFolder($service, $folderName, $parentId);
    }
    private function uploadToGoogleDrive($file, $filename, $subFolderPath = null)
    {
        $credentialsPath = storage_path('app/google/credentials.json');
        $mainFolderId = '1A2B3C4D5E6F7G8H9';
        $client = new \Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(\Google_Service_Drive::DRIVE);
        $service = new \Google_Service_Drive($client);
        $parentId = $mainFolderId;
        if ($subFolderPath) {
            $parts = explode('/', $subFolderPath);
            foreach ($parts as $part) {
                $parentId = $this->findOrCreateFolder($service, $part, $parentId);
            }
        }
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $filename,
            'parents' => [$parentId],
        ]);
        $content = file_get_contents($file->getPathname());
        $uploadedFile = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id',
        ]);
        $permission = new \Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);
        $service->permissions->create($uploadedFile->id, $permission);
        return 'https://drive.google.com/file/d/' . $uploadedFile->id . '/view';
    }
}
