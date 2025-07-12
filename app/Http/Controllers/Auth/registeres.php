<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Http;

class registeres extends Controller
{
    public function register(Request $request)
    {
        $username = $request->input('username');
        $nameuse = $request->input('nameuse');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        $existingUser = Users::where('username', $username)->first();
        $existingEmail = Users::where('email', $email)->first();
        if ($existingUser) {
            return redirect()->route('authes')->with(['alert' => 'Username sudah digunakan!', 'form' => 'register']);
        }
        $apiKey = env('GEMINI_API');
        $prompt = 'Anda adalah seorang moderator konten yang cerdas. Tugas Anda adalah menganalisis teks untuk mendeteksi apakah teks tersebut merupakan PENGHINAAN atau SERANGAN PERSONAL yang menggunakan nama binatang. ' .
            'Jika teks hanya menyebut nama binatang tanpa konteks menghina, loloskan saja. ' .
            'Contoh yang harus dianggap toksik (is_toxic: true): "Kamu anjing", "Dasar monyet", "Otak udang". ' .
            'Contoh yang harus dianggap aman (is_toxic: false): "Anjing", "Saya punya kucing", "Monyet makan pisang". ' .
            'Sekarang, analisis teks berikut dan berikan respons HANYA dalam format JSON yang ketat dengan kunci "is_toxic" (boolean) dan "reason" (string). ' .
            'Teksnya adalah: "' . $username . "dan" . $nameuse . '"';
        $response = Http::timeout(120)->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey,
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]
        );
        if ($response->successful()) {
            $geminiResultText = $response->json('candidates.0.content.parts.0.text');
            preg_match('/\{.*\}/s', $geminiResultText, $matches);
            $analysisResult = null;
            if (!empty($matches[0])) {
                $analysisResult = json_decode($matches[0], true);
            }
            if (isset($analysisResult['is_toxic']) && $analysisResult['is_toxic'] == true) {
                return redirect()->route('authes')->with(['alert' => 'Username dan Nameuse mengandung kata kata kasar!', 'form' => 'register']);
            }
        }
        if ($existingEmail) {
            return redirect()->route('authes')->with(['alert' => 'Email sudah digunakan!', 'form' => 'register']);
        }
        if ($password !== $password_confirmation) {
            return redirect()->route('authes')->with(['alert' => 'Password dan Konfirmasi Password tidak cocok!', 'form' => 'register']);
        }
        session([
            'regis' => true,
            'username' => $username,    
            'bio' => 'Hai aku pengguna baru',
            'nameuse' => $nameuse,
            'email' => $email,
            'password' => $password,
        ]);
        return redirect()->route('authes')->with(['alert' => 'Selesaikan captcha terlebih dahulu!', 'form' => 'captcha']);
    }
}
