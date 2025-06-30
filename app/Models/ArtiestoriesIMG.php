<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtiestoriesIMG extends Model
{
    protected $table = 'artiestoriesimg'; 
    protected $primaryKey = 'artiestoriesimgid';
    protected $fillable = ['artiestoriesid', 'konten', 'deltime'];
    public $timestamps = true;
    public function post() {
        return $this->belongsTo(Artiestories::class);
    }
}
