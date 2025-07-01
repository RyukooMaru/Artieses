<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtiestoriesType extends Model
{
    protected $table = 'artiestoriestype'; 
    protected $primaryKey = 'artiestoriestypeid';
    protected $fillable = ['artiestoriesid', 'konten', 'type', 'deltime'];
    public $timestamps = true;
    public function post() {
        return $this->belongsTo(Artiestories::class);
    }
}
