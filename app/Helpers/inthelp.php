<?php

namespace App\Helpers;

use Carbon\Carbon;

class inthelp
{
    public static function formatAngka($angka)
    {
        if ($angka >= 1000000000) {
            return round($angka / 1000000000, 1) . 'm'; // miliar
        } elseif ($angka >= 1000000) {
            return round($angka / 1000000, 1) . 'jt'; // juta
        } elseif ($angka >= 1000) {
            return round($angka / 1000, 1) . 'rb'; // ribu
        }
        return (string) $angka;
    }
    public static function formatWaktu($waktu)
    {
        $now = Carbon::now();

        $diffInMinutes = (int) $waktu->diffInMinutes($now);
        if ($diffInMinutes < 60) {
            return $diffInMinutes . ' menit yang lalu';
        }

        $diffInHours = (int) $waktu->diffInHours($now);
        if ($diffInHours < 24) {
            return $diffInHours . ' jam yang lalu';
        }

        $diffInDays = (int) $waktu->diffInDays($now);
        if ($diffInDays < 7) {
            return $diffInDays . ' hari yang lalu';
        }

        return $waktu->format('d M Y');
    }
}