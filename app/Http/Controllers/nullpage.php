<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class nullpage extends Controller
{
    public function handle(Request $request)
    {
        $fullPath = $request->path();
        return view('blankpage', ['requested' => $fullPath]);
    }
}
