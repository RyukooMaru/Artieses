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
use Illuminate\Support\Facades\Storage;

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
                $storagePath = session('username') . '/artiestoriescomments/';
                $path1 = 'storage/' . $storagePath;
                $existingImages = glob($path1 . '/imgcomment0*.png');
                $count = count($existingImages) + 1;
                $filename = "imgcomment0{$count}-{$coderies}-{$requscom}.png";
                $path = 'storage/' . $storagePath . '/' . $filename;
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Storage::disk('public')->putFileAs($storagePath, $file, $filename);
                $inputcomments = '<img src="' . url('/Artiestoriescom/' . $filename . '?GetContent=' . $coderies) . '" class="imgcom">';
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
                $reqplat = $request->input('storyCode1');
                $code = $request->input('code');
                $file = $request->file('fileInput1');
                $storagePath = session('username') . '/artiestoriescomments/';
                $path1 = 'storage/' . $storagePath;
                $existingImages = glob($path1 . '/imgcomment*.png');
                $count = count($existingImages) + 1;
                $filename = "imgcomment1{$count}-{$code}-{$requscom}.png";
                $path = 'storage/' . $storagePath . '/' . $filename;
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Storage::disk('public')->putFileAs($storagePath, $file, $filename);
                $inputcomments = '<img src="' . url('/Artiestoriescom/' . $filename . '?GetContent=' . $code) . '" class="imgcom">';
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
            return response()->json(['username' => $username, 'userid' => $userid, 'message' => $inputcomments, 'commentartiestoriesid' => $reqplat, 'improfil' => $improfil, 'created_at' => $timeAgo, 'balcomstoriesid' => $comstoriesid,'jumlah' => $jumlah]);
        }
    }
}
