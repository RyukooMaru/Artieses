<?php
namespace App\Helpers;

class AuthHelper
{
    // Fungsi untuk mengecek apakah pengguna sudah login
    public static function check()
    {
        return session()->has('isLoggedIn') && session('isLoggedIn') === true;
    }
}
?>