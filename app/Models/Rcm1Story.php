<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rcm1Story extends Model
{
    protected $table = 'rcm1story';
    protected $primaryKey = 'rcm1storyid';
    public $incrementing = true;
    protected $fillable = ['userid', 'commentartiestoriesid', 'reaksi'];
    public $timestamps = true;
}
