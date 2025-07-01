<?php
namespace App\Http\Controllers\App\profil;

use App\Http\Controllers\Controller;
use App\Http\Controllers\nullpage;
use App\Models\Artiekeles;
use App\Models\Artiestories;
use App\Models\Artievides;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;

class profilcontroller extends Controller
{
    public function show(Request $request, $username)
    {    
        $reqplat = $request->query('GetContent') ?? session('artiestoriesid');
        $user = Users::where('username', $username)->whereNull('deleteaccount')->first();
        if (!$user) {
            $user = Users::where('username', $username)->first();

            if (!$user) {
                return app(nullpage::class)->handle(request());
            }
            return app(nullpage::class)->handle(request());
        }
        $videscontent = Artievides::where('userid', $user->userid)
                        ->whereNull('deltime')
                        ->orderByDesc('created_at')
                        ->get();
        $storiescontent = Artiestories::where('userid', $user->userid)
                        ->whereNull('deltime')
                        ->orderByDesc('created_at')
                        ->get();
        $articlescontent = Artiekeles::where('userid', $user->userid)
                        ->whereNull('deltime')
                        ->orderByDesc('created_at')
                        ->get();
        $subscriber = $user->subscriber()->latest()->get();
        $subscribing = $user->subscribing()->latest()->get();
        return view('appes.Artieprofil', [
        'user' => $user,
        'stories' => $storiescontent,
        'open_commentarist' => $reqplat,
        ], compact('user', 'videscontent', 'storiescontent', 'articlescontent', 'subscriber', 'subscribing'));
    }
    public function updateUsername(Request $request, $username)
    {
        $user = Users::where('username', $username)->firstOrFail();
        $request->validate([
            'username' => 'required|string|max:255'
        ]);
        $lastUpdated = $user->editusername;
        if (!$request->username || strlen($request->username) < 3) {
            return response()->json(['success' => false, 'message' => 'Username tidak valid.']);
        }
        if ($lastUpdated && now()->diffInDays($lastUpdated) < 7) {
            return response()->json([
                'success' => false,
                'message' => 'Username hanya bisa diubah setiap 7 hari.'
            ]);
        }
        if (Users::where('username', $request->username)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Username sudah digunakan.'
            ]);
        }
        $user->username = $request->username;
        $user->editusername = now();
        $user->save();
        session(['username' => $request->username]);
        return response()->json([
            'success' => true,
            'redirect' => route('profiles.show', ['username' => $request->username])
        ]);
    }
    public function updatenameuse(Request $request, $username)
    {
        $request->validate([
            'nameuse' => 'required|string|max:255'
        ]);
        $user = Users::where('username', $username)->firstOrFail();
        $user->nameuse = $request->nameuse;
        $user->save();
        session(['nameuse' => $request->nameuse]);
        return response()->json(['success' => true]);
    }
    public function updateBio(Request $request, $username)
    {
        $request->validate([
            'bio' => 'nullable|string|max:255',
        ]);
        $user = Users::where('username', $username)->firstOrFail();
        $user->bio = $request->bio;
        $user->save();
        session(['bio' => $request->bio]);
        return response()->json(['success' => true]);
    }
    public function updatefoto(Request $request, $username)
    {
        $request->validate([
            'foto' => 'required|mimes:jpeg,jpg,png,gif,webp'
        ]);
        $user = Users::where('username', $username)->firstOrFail();
        $file = $request->file('foto');
        $credentialsPath = base_path(env('GOOGLE_CREDENTIAL_PATH'));
        $mainFolderId = '1dAtghVH4G3rgOoypIkdqUKAh6uslcHIQ';
        $client = new Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(Google_Service_Drive::DRIVE);
        $service = new Google_Service_Drive($client);
        if ($user->improfil) {
            $oldFileId = $user->improfil;
            try {
                $service->files->delete($oldFileId);
            } catch (\Exception $e) {
            }
        }
        $tempName = 'temp_' . time() . '.' . $file->getClientOriginalExtension();
        $fileMetadata = new Google_Service_Drive_DriveFile([
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
        $updateMetadata = new Google_Service_Drive_DriveFile([
            'name' => $newName
        ]);
        $service->files->update($uploadedFile->id, $updateMetadata);
        $permission = new Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);
        $service->permissions->create($uploadedFile->id, $permission);
        $user->improfil = $uploadedFile->id;
        $user->save();
        session(['improfil' => $uploadedFile->id]);
        return response()->json(['success' => true]);
    }
}