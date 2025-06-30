<?php

namespace App\Http\Controllers\App\artievides;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artievides;
use Illuminate\Support\Facades\Storage;

class controllerartievides extends Controller
{
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
        $videoFile = $request->file('video');
        if ($videoFile == null) {
            return redirect()->route('artieses')->with(['alert' => 'Thumbnail harus berupa mp4,avi,mov,wmv,mkv,flv,mpeg,3gp!']);
        }
        $videoName = time() . '_' . $videoFile->getClientOriginalName();
        $videoPath = session('username') . '/artievides/' . $randomString;
        Storage::disk('public')->putFileAs($videoPath, $videoFile, $videoName);
        $videoPathRelatif = session('username') . '/artievides/' . $randomString . '/' . $videoName;
        $thumbFile = $request->file('thumbnail');
        if ($thumbFile == null) {
            return redirect()->route('artieses')->with(['alert' => 'Thumbnail harus berupa jpeg,png,jpg,svg!']);
        }
        $thumbName = time() . '_' . $thumbFile->getClientOriginalName();
        $thumbPath = session('username') . '/artiethumb/' . $randomString;
        if (!file_exists($thumbPath)) mkdir($thumbPath, 0755, true);
        Storage::disk('public')->putFileAs($thumbPath, $thumbFile, $thumbName);
        $thumbPathRelatif = session('username') . '/artiethumb/' . $randomString . '/' . $thumbName;
        Artievides::create([
            'userid' => session('userid'),
            'codevides' => $randomString,
            'judul' => $judul,
            'lseo' => $lseo,
            'kseo' => $kseo,
            'video' => $videoPathRelatif,
            'thumbnail' => $thumbPathRelatif,
        ]);
        return redirect()->route('artieses')->with(['alert' => 'Artievides mu sudah di publish!']);
    }
}
