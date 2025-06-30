<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Searches extends Model
{
    protected $table = 'searches'; 
    protected $fillable = ['userid', 'search'];
    public $timestamps = true;
}
