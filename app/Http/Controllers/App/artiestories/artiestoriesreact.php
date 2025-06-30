<?php

namespace App\Http\Controllers\App\artiestories;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rcm1Story;
use App\Models\Rcm2Story;
use App\Models\ReactStories;

class artiestoriesreact extends Controller
{
    public function store(Request $request)
    {
        if (!AuthHelper::check()) {
            return response()->json([
                'logged_in' => false,
                'redirect' => route('authes'),
                'alert' => 'Harus login dulu!',
                'form' => 'login'
            ]);
        }
        $validated = $request->validate([
            'reaksi' => 'required|string',
            'artiestoriesid' => 'required|integer|exists:artiestories,artiestoriesid',
        ]);
        $existingReaction = ReactStories::where('userid', session('userid'))->where('artiestoriesid', $validated['artiestoriesid'])->first();
        if ($existingReaction) {
            $existingReaction->reaksi = $validated['reaksi'];
            $existingReaction->save();
            $message = 'Reaksi berhasil diperbarui';
            $created = $existingReaction;
        } else {
            $created = ReactStories::create([
                'userid' => session('userid'),
                'artiestoriesid' => $validated['artiestoriesid'],
                'reaksi' => $validated['reaksi'],
            ]);
            $message = 'Reaksi berhasil ditambahkan';
        }
        return response()->json([
            'logged_in' => true,
            'success' => true,
            'message' => $message,
            'data' => $created,
            'csrf' => csrf_token()
        ]);
    }
    public function store2(Request $request)
    {
        if (!AuthHelper::check()) {
            return response()->json([
                'logged_in' => false,
                'redirect' => route('authes'),
                'alert' => 'Harus login dulu!',
                'form' => 'login'
            ]);
        }
        $validated = $request->validate([
            'reaksi' => 'required|string',
            'commentartiestoriesid' => 'required|integer|exists:commentartiestories,commentartiestoriesid',
        ]);
        $existingReaction = Rcm1Story::where('userid', session('userid'))->where('commentartiestoriesid', $validated['commentartiestoriesid'])->first();
        if ($existingReaction) {
            $existingReaction->reaksi = $validated['reaksi'];
            $existingReaction->save();
            $message = 'Reaksi berhasil diperbarui';
            $created = $existingReaction;
        } else {
            $created = Rcm1Story::create([
                'userid' => session('userid'),
                'commentartiestoriesid' => $validated['commentartiestoriesid'],
                'reaksi' => $validated['reaksi'],
            ]);
            $message = 'Reaksi berhasil ditambahkan';
        }
        return response()->json([
            'logged_in' => true,
            'success' => true,
            'message' => $message,
            'data' => $created,
            'csrf' => csrf_token()
        ]);
    }
    public function store3(Request $request)
    {
        if (!AuthHelper::check()) {
            return response()->json([
                'logged_in' => false,
                'redirect' => route('authes'),
                'alert' => 'Harus login dulu!',
                'form' => 'login'
            ]);
        }
        $validated = $request->validate([
            'reaksi' => 'required|string',
            'balcomstoriesid' => 'required|integer|exists:balcomstories,balcomstoriesid',
        ]);
        $existingReaction = Rcm2Story::where('userid', session('userid'))->where('balcomstoriesid', $validated['balcomstoriesid'])->first();
        if ($existingReaction) {
            $existingReaction->reaksi = $validated['reaksi'];
            $existingReaction->save();
            $message = 'Reaksi berhasil diperbarui';
            $created = $existingReaction;
        } else {
            $created = Rcm2Story::create([
                'userid' => session('userid'),
                'balcomstoriesid' => $validated['balcomstoriesid'],
                'reaksi' => $validated['reaksi'],
            ]);
            $message = 'Reaksi berhasil ditambahkan';
        }
        return response()->json([
            'logged_in' => true,
            'success' => true,
            'message' => $message,
            'data' => $created,
            'csrf' => csrf_token()
        ]);
    }
}
