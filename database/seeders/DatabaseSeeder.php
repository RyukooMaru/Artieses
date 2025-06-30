<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        DB::table('users')->insert([
            'username' => 'Ini Admin',
            'nameuse' => 'jangan senggol admin',
            'bio' => 'hai selamat datang',
            'email' => 'artiesesofficial@gmail.com',
            'password' => hash::make('asdqweasd'),
            'improfil' => 'Ini Admin.gif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'username' => 'Ini User',
            'nameuse' => 'ampun sepuh admin aku takut',
            'bio' => 'hai selamat datang',
            'email' => 'ryukoogi712@gmail.com',
            'password' => hash::make('asdqweasd'),
            'improfil' => 'Ini User.gif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('admin')->insert([
            'userid' => '1',
            'activity' => 'buat akun admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // DB::table('artiestories')->insert([
        //     [
        //         'userid' => 2,
        //         'caption' => 'Hai Aku cinta Kalian Semua',
        //         'lseo' => 'Ganteng',
        //         'kseo' => 'Teknologi',
        //         'konten' => 'Ini User/artiestories/1746504917_Screenshot (27).png',
        //         'created_at' => '2025-05-06 04:15:17',
        //         'updated_at' => '2025-05-06 04:15:17',
        //     ],
        //     [
        //         'userid' => 2,
        //         'caption' => 'Hai Aku cinta Kalian Semua',
        //         'lseo' => 'Ganteng',
        //         'kseo' => 'Teknologi',
        //         'konten' => 'Ini User/artiestories/1746508011_Screenshot (25).png',
        //         'created_at' => '2025-05-06 05:06:51',
        //         'updated_at' => '2025-05-06 05:06:51',
        //     ],
        // ]);
        // DB::table('artievides')->insert([
        //     [
        //         'userid' => 2,
        //         'judul' => 'Ini Aku',
        //         'lseo' => 'Ini adalah Aku',
        //         'kseo' => null,
        //         'video' => 'Ini Admin/artievides/1746504435_Honkai_ Star Rail 2025-04-12 18-22-48.mp4',
        //         'thumbnail' => 'Ini Admin/artithumbs/1746504439_Screenshot (1800)[1].png',
        //         'created_at' => '2025-05-06 04:07:19',
        //         'updated_at' => '2025-05-06 04:07:19',
        //     ],
        //     [
        //         'userid' => 2,
        //         'judul' => 'Ini Aku',
        //         'lseo' => 'Apa Aja',
        //         'kseo' => 'Teknologi',
        //         'video' => 'Ini Admin/artievides/1746504751_Genshin Impact 2023-09-20 06-27-31.mp4',
        //         'thumbnail' => 'Ini Admin/artithumbs/1746504751_Screenshot (57).png',
        //         'created_at' => '2025-05-06 04:12:31',
        //         'updated_at' => '2025-05-06 04:12:31',
        //     ],
        //     [
        //         'userid' => 1,
        //         'judul' => 'Ini Aku',
        //         'lseo' => 'Ganteng',
        //         'kseo' => 'Teknologi',
        //         'video' => 'Ini Admin/artievides/1746504828_Genshin Impact 2023-09-20 06-56-50.mp4',
        //         'thumbnail' => 'Ini Admin/artithumbs/1746504828_Screenshot (15).png',
        //         'created_at' => '2025-05-06 04:13:48',
        //         'updated_at' => '2025-05-06 04:13:48',
        //     ],
        //     [
        //         'userid' => 2,
        //         'judul' => 'Ini Kamu',
        //         'lseo' => 'Ganteng',
        //         'kseo' => 'Lingkungan',
        //         'video' => 'Ini User/artievides/1746504879_Genshin Impact 2023-09-20 07-13-59.mp4',
        //         'thumbnail' => 'Ini User/artithumbs/1746504879_Screenshot (27).png',
        //         'created_at' => '2025-05-06 04:14:39',
        //         'updated_at' => '2025-05-06 04:14:39',
        //     ],
        // ]);
        // DB::table('likeartievides')->insert([
        //     'userid' => '1',
        //     'artievidesid' => '2',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // DB::table('likeartievides')->insert([
        //     'userid' => '2',
        //     'artievidesid' => '2',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        // DB::table('commentartiestories')->insert([
        //     'userid' => '2',
        //     'artiestoriesid' => '1',
        //     'commentses' => 'hai kamu dimana',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        //  ]);
        // DB::table('balcomstories')->insert([
        //     'userid' => '1',
        //     'commentartiestoriesid' => '2',
        //     'comment' => 'hai aku disini',
        //     'created_at' => now(),
        //      'updated_at' => now(),
        // ]);   
    }
}
