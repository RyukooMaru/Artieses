<?php

namespace App\Http\Controllers\App\artievides;

use Illuminate\Http\Request;
use App\Models\Artievides;

class LikeController
{
    public function like($codevides)
    {
        $video = Artievides::where('codevides', $codevides)->firstOrFail();
        $video->like_vides_count = ($video->like_vides_count ?? 0) + 1;
        $video->save();

        return response()->json([
            'status' => 'success',
            'likes' => $video->like_vides_count
        ]);
    }
    public function dislike($codevides)
    {
        $video = Artievides::where('codevides', $codevides)->firstOrFail();
        $video->like_vides_count = max(0, ($video->like_vides_count ?? 0) - 1);
        $video->save();

        return response()->json([
            'status' => 'success',
            'likes' => $video->like_vides_count
        ]);
    }
}
