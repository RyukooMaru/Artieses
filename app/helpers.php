<?php
if (!function_exists('formatAngka')) {
    function formatAngka($angka)
    {
        if ($angka >= 1000000000) {
            return round($angka / 1000000000, 1) . 'm';
        } elseif ($angka >= 1000000) {
            return round($angka / 1000000, 1) . 'jt';
        } elseif ($angka >= 1000) {
            return round($angka / 1000, 1) . 'rb';
        }
        return $angka;
    }
}

