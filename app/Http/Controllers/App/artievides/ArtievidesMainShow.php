<?php

namespace App\Http\Controllers\App\artievides;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Artievides;
use Illuminate\Support\Facades\DB;

class ArtievidesMainShow extends Controller
{
    public function ArtievidesMainShow(Request $request) {
        $reqplat = $request->query('GetContent');
        $cekcontent = Artievides::with('usericonVides')
                    ->whereNull('deltime')
                    ->whereHas('usericonVides', function ($query) {
                        $query->whereNull('deleteaccount');
                    })
                    ->when($reqplat, function ($queryBuilder) use ($reqplat) {
                                $queryBuilder->where(function ($q) use ($reqplat) {
                                            $q->where('codevides', $reqplat);
                                });
                    })->firstOrFail();
        if ($cekcontent->isEmpty()) {
            $fullPath = $request->path();
            return view('blankpage', ['requested' => $fullPath]);
        }
        $video = Artievides::where('codevides', $reqplat)->firstOrFail();
        $user = $video->usericonVides;
        $subscriber = $user->subscriber()->latest()->get();
        $views = $video->banyakviewyahemangiyah()->latest()->get();
        $cookieName = 'video_viewed_' . $reqplat;
        $currentUserId = session('userid');
        $isOwner = $currentUserId == $video->userid;
        if (!$isOwner) {
            $alreadyViewed = DB::table('banyakviewyah?emangiyah?')
                ->where('codevides', $reqplat)
                ->where('banyakviewyah?emangiyah?wkwk', $cookieName)
                ->exists();
            if (!$alreadyViewed) {
                DB::table('banyakviewyah?emangiyah?')->insert([
                    'codevides' => $reqplat,
                    'banyakviewyah?emangiyah?wkwk' => $cookieName,
                    'created_at' => now(),
                ]);
            }
        }
        $searchWords = collect(explode(' ', $video->judul))
            ->merge(explode(' ', $video->kseo))
            ->merge(explode(' ', $video->lseo))
            ->filter()
            ->unique();
        if ($searchWords->isEmpty()) {
            $relatedVideos = Artievides::with('usericonVides')
                ->where('codevides', '!=', $video->codevides)
                ->whereNull('deltime')
                ->whereHas('usericonVides', function ($query) {
                    $query->whereNull('deleteaccount');
                })
                ->withCount('likeVides')
                ->orderByDesc('like_vides_count')
                ->orderByDesc('created_at')
                ->get();
        } else {
            $relatedVideos = Artievides::with('usericonVides')
                ->where('codevides', '!=', $video->codevides)
                ->whereNull('deltime')
                ->whereHas('usericonVides', function ($query) {
                    $query->whereNull('deleteaccount');
                })
                ->where(function ($query) use ($searchWords) {
                    foreach ($searchWords as $word) {
                        $trimmedWord = trim($word);
                        if (!empty($trimmedWord)) {
                            $query->orWhere('judul', 'LIKE', '%' . $trimmedWord . '%')
                                ->orWhere('kseo', 'LIKE', '%' . $trimmedWord . '%')
                                ->orWhere('lseo', 'LIKE', '%' . $trimmedWord . '%');
                        }
                    }
                })
                ->withCount('likeVides')
                ->orderByDesc('like_vides_count')
                ->orderByDesc('created_at')
                ->get();
        }
        return view('appes.artievides.mainvides', compact(
            'reqplat', 
            'video', 
            'user', 
            'subscriber', 
            'views', 
            'relatedVideos'
        ));
    }
}