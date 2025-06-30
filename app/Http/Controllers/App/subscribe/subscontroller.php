<?php

namespace App\Http\Controllers\App\subscribe;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\Subs;
use Illuminate\Http\Request;

class subscontroller extends Controller
{
    public function addsubs(Request $request)
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
            'subscribing' => 'required|integer|exists:users,userid',
        ]);
        $subscriberId = session('userid');
        $existingSubscription = Subs::where('subscriber', $subscriberId)->where('subscribing', $validated['subscribing'])->first();
        if ($existingSubscription) {
            $existingSubscription->delete();
            $message = "Berhasil unsubscribe";
            $data = null;
        } else {
            $data = Subs::create([
                'subscriber' => $subscriberId,
                'subscribing' => $validated['subscribing'],
            ]);
            $message = "Berhasil subscribe";
        }
        return response()->json([
            'logged_in' => true,
            'success' => true,
            'message' => $message,
            'data' => $data,
            'csrf' => csrf_token(),
        ]);

    }
}
