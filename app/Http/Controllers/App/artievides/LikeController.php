<?php

namespace App\Http\Controllers\App\artievides;

use App\Models\dislikevides;
use App\Models\likevides;

class LikeController
{
    public function like($codevides)
    {
        likevides::create([
            'userid' => session('userid'),
            'codevides' => $codevides,
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function dislike($codevides)
    {
        dislikevides::create([
            'userid' => session('userid'),
            'codevides' => $codevides,
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
