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
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $url = 'users/' .$username . '/profil';
        $destination = public_path($url);
        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }
        $file->move($destination, $filename);
        $user->improfil = $url . '/' . $filename;
        $user->save();
        session(['improfil' => $url . '/' . $filename]);
        return response()->json(['success' => true]);
    }
}