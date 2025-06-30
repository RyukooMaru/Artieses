<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artiekeles extends Model
{
    protected $table = 'artiekeles'; 
    protected $fillable = ['userid','codekeles', 'judul', 'lseo', 'kseo', 'konten', 'deltime'];
    public $timestamps = true;
}