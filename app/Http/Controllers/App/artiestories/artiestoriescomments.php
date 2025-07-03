<?php

namespace App\Http\Controllers\App\artiestories;

use App\Events\BroadcastTyping;
use App\Events\BroadcastTyping1;
use App\Events\UserTyping;
use App\Events\UserTyping1;
use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\BalcomStories;
use Illuminate\Http\Request;
use App\Models\ComStories;

class artiestoriescomments extends Controller
{
    public function broadcast(Request $request) {
        if (!AuthHelper::check()) {
            return response()->json([
                'logged_in' => false,
                'redirect' => route('authes'),
                'alert' => 'Harus login dulu!',
                'form' => 'login'
            ]);
        }
        $username = session('username');
        $inputcomments = $request->input('message');
        $reqplat = $request->input('comentses');
        broadcast(new BroadcastTyping($username, $reqplat, $inputcomments));
        return response()->json([
            'status' => 'broadcasted',
            'username' => $username,
            'coderies' => $reqplat,
            'message' => $inputcomments
        ]);
    }
    public function broadcast1(Request $request) {
        if (!AuthHelper::check()) {
            return response()->json([
                'logged_in' => false,
                'redirect' => route('authes'),
                'alert' => 'Harus login dulu!',
                'form' => 'login'
            ]);
        }
        $username = session('username');
        $reqplat = $request->input('comentses1');
        $message = $request->input('message1');
        broadcast(new BroadcastTyping1($username, $reqplat, $message));
        return response()->json([
            'status' => 'broadcasted',
            'username' => $username,
            'comstoriesid' => $reqplat,
            'message' =>  $message
        ]);
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
    public function storeGG(Request $request)
    {
        if (session()->has('username')) {
            $coderies = $request->input('coderies');
            $requscom = session('userid');
            $username = session('username');
            $inputcomments = '';
            $filename = null;
            if (!$request->input('message') && $request->hasFile('fileInput')) {
                $file = $request->file('fileInput');
                $fileid = $this->uploadToGoogleDrive($file);
                $path = url("/konten/" . $fileid);
                $inputcomments = '<img src="' . $path . '" class="imgcom">';
            }
            if (!$request->hasFile('fileInput')) {
                $inputcomments = $request->input('message');
            }
            $comstories = ComStories::create([
                'userid' => $requscom,
                'coderies' => $coderies,
                'commentses' => $inputcomments,
            ]);
            $message = $inputcomments;
            $improfil = session('improfil', 'default.png');
            $created_at = $comstories->created_at;
            $comstoriesid = $comstories->commentartiestoriesid;
            $now = \Carbon\Carbon::now();
            $diffInMinutes001 = $created_at->diffInMinutes($now);
            $diffInHours001 = $created_at->diffInHours($now);
            $diffInDays001 = $created_at->diffInDays($now);
            $diffInWeeks001 = $created_at->diffInWeeks($now);
            $diffInMonths001 = $created_at->diffInMonths($now);
            $diffInYears001 = $created_at->diffInYears($now);
            $diffInMinutes = (int) $diffInMinutes001;
            $diffInHours = (int) $diffInHours001;
            $diffInDays = (int) $diffInDays001;
            $diffInWeeks = (int) $diffInWeeks001;
            $diffInMonths = (int) $diffInMonths001;
            $diffInYears = (int) $diffInYears001;
            if ($diffInMinutes < 60) {
                $timeAgo = $diffInMinutes . ' menit yang lalu';
            } elseif ($diffInHours < 24) {
                $timeAgo = $diffInHours . ' jam yang lalu';
            } elseif ($diffInDays < 7) {
                $timeAgo = $diffInDays . ' hari yang lalu';
            } elseif ($diffInWeeks < 4) {
                $timeAgo = $diffInWeeks . ' minggu yang lalu';
            } elseif ($diffInMonths < 12) {
                $timeAgo = $diffInMonths . ' bulan yang lalu';
            } else {
                $timeAgo = $diffInYears . ' tahun yang lalu';
            }
            broadcast(new UserTyping($username, $message, $filename,$improfil, $coderies, $timeAgo, $comstoriesid));
            return response()->json([
                'status' => $coderies,
                'filename' => $filename,
                'message' => $inputcomments
            ]);
        }
    }
    public function storeGG1(Request $request)
    {
        if (session()->has('username')) {
            $requscom = session('userid');
            $username = session('username');
            $inputcomments = '';
            $filename = null;
            if (!$request->input('message1') && $request->hasFile('fileInput1')) {
                $file = $request->file('fileInput1');
                $fileid = $this->uploadToGoogleDrive($file);
                $path = url("/konten/" . $fileid);
                $inputcomments = '<img src="' . $path . '" class="imgcom">';
            }
            if (!$request->hasFile('fileInput1')) {
                $reqplat = $request->input('storyCode1');
                $inputcomments = $request->input('message1');
            }
            $comstories = BalcomStories::create([
                'userid' => $requscom,
                'commentartiestoriesid' => $reqplat,
                'comment' => $inputcomments,
            ]);
            $message = $inputcomments;
            $improfil = session('improfil');
            $created_at = $comstories->created_at;
            $comstoriesid = $comstories->balcomstoriesid;
            $now = \Carbon\Carbon::now();
            $diffInMinutes001 = $created_at->diffInMinutes($now);
            $diffInHours001 = $created_at->diffInHours($now);
            $diffInDays001 = $created_at->diffInDays($now);
            $diffInWeeks001 = $created_at->diffInWeeks($now);
            $diffInMonths001 = $created_at->diffInMonths($now);
            $diffInYears001 = $created_at->diffInYears($now);
            $diffInMinutes = (int) $diffInMinutes001;
            $diffInHours = (int) $diffInHours001;
            $diffInDays = (int) $diffInDays001;
            $diffInWeeks = (int) $diffInWeeks001;
            $diffInMonths = (int) $diffInMonths001;
            $diffInYears = (int) $diffInYears001;
            if ($diffInMinutes < 60) {
                $timeAgo = $diffInMinutes . ' menit yang lalu';
            } elseif ($diffInHours < 24) {
                $timeAgo = $diffInHours . ' jam yang lalu';
            } elseif ($diffInDays < 7) {
                $timeAgo = $diffInDays . ' hari yang lalu';
            } elseif ($diffInWeeks < 4) {
                $timeAgo = $diffInWeeks . ' minggu yang lalu';
            } elseif ($diffInMonths < 12) {
                $timeAgo = $diffInMonths . ' bulan yang lalu';
            } else {
                $timeAgo = $diffInYears . ' tahun yang lalu';
            }
            $userid = session('userid');
            $jumlah = BalcomStories::where('commentartiestoriesid', $reqplat)->count();
            broadcast(new UserTyping1($userid, $username, $message, $comstoriesid, $improfil, $timeAgo, $filename, $jumlah, $reqplat));
            return response()->json(['logged_in' => true, 'username' => $username, 'userid' => $userid, 'message' => $inputcomments, 'commentartiestoriesid' => $reqplat, 'improfil' => $improfil, 'created_at' => $timeAgo, 'balcomstoriesid' => $comstoriesid,'jumlah' => $jumlah]);
        }
    }
}
