<?php
namespace App\Http\Controllers;

use App\Models\Artiestories;
use App\Models\BalcomStories;
use App\Models\ComStories;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Events\hapuscomment;
use App\Events\hapuscomment1;

class DeleteKonten extends Controller
{
    public function delete(Request $request){
        $user = Users::where('username', session('username'))->first();
        $siadmin = $user->admin;
        $story = null;
        $video = null;
        $pemilik = null;
        if($request->json('id')){
            $comment = ComStories::where('commentartiestoriesid', $request->json('id'))->first();
            $id = $comment->commentartiestoriesid;
            $comment->forceDelete();
            broadcast(new hapuscomment($id));
            return response()->json(['success' => true, 'commentid' => $id]);
        }
        if($request->json('id1')){
            $comment = BalcomStories::where('balcomstoriesid', $request->json('id1'))->first();
            $id1 = $comment->balcomstoriesid;
            $id = $comment->commentartiestoriesid;
            $comment->forceDelete();
            broadcast(new hapuscomment1($id1, $id));
            return response()->json(['success' => true, 'commentid' => $id1, 'akarid' => $id]);
        }
        if($request->json('artiestoriesid')){
            $story = Artiestories::where('coderies', $request->json('artiestoriesid'))->first();
            if ($story) {
                $pemilik = $story->usericonStories->username;
            }
        }
        if (!$story && !$video) {
            return response()->json(['success' => false, 'message' => 'Konten tidak ditemukan']);
        }
        if (session('username') == $pemilik) {
            if ($story) {
                if (session('deleteitsuser1')){
                    session()->forget(['deleteitsuser1', 'artiestoriesid', 'runDelete']);
                    $story->deltime = now();
                    $story->save();
                    return response()->json(['success' => true]);
                } else {
                    session(['deleteistuser' => true]);
                    session(['artiestoriesid' => $request->json('artiestoriesid')]);
                    return response()->json(['success' => false, 'requireCaptcha' => true]);
                }
            }
            if ($video) {
                if (session('deleteitsuser1')){
                    session()->forget(['deleteitsuser1', 'artievidesid', 'runDelete']);
                    $video->deltime = now();
                    $video->save();
                    return response()->json(['success' => true]);
                } else {
                    session(['deleteistuser' => true]);
                    session(['artievidesid' => $request->json('artievidesid')]);
                    return response()->json(['success' => false, 'requireCaptcha' => true]);
                }
            }
        } if($siadmin) {
            if ($story) {
                $siadmin->activity = 'Menghapus konten' . $request->json('artiestoriesid') . 'Pemilik:' . $pemilik;
                $story->deltime = now();
                $story->save();
                return response()->json(['success' => true]);
            }
            if ($video) {
                $siadmin->activity = 'Menghapus konten' . $request->json('artievidesid') . 'Pemilik:' . $pemilik;
                $video->deltime = now();
                $video->save();
                return response()->json(['success' => true]);
            }
        }
    }
}