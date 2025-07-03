<?php
namespace App\Http\Controllers;

use App\Models\Artiestories;
use App\Models\Users;
use Illuminate\Http\Request;

class DeleteKonten extends Controller
{
    public function delete(Request $request){
        $user = Users::where('username', session('username'))->first();
        $siadmin = $user->admin;
        $storyId = $request->json('artiestoriesid');
        $story = Artiestories::where('coderies', $storyId)->first();
        $pemilik = $story->usericonStories->username;
        if (session('username') == $pemilik) {
            if (!$story) {
                return response()->json(['success' => false, 'message' => 'Konten tidak ditemukan']);
            }
            if (session('deleteitsuser1')){
                session()->forget(['deleteitsuser1', 'artiestoriesid', 'runDelete']);
                $story->deltime = now();
                $story->save();
                return response()->json(['success' => true]);
            } else {
                session(['deleteistuser' => true]);
                session(['artiestoriesid' => $storyId]);
                return response()->json(['success' => false, 'requireCaptcha' => true]);
            }
        } if($siadmin) {
            if (!$story) {
                return response()->json(['success' => false, 'message' => 'Konten tidak ditemukan']);
            }
            $siadmin->activity = 'Menghapus konten' . $storyId . 'Pemilik:' . $pemilik;
            $story->deltime = now();
            $story->save();
            return response()->json(['success' => true]);
        }
    }
}