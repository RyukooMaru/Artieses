<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class likevides extends Model
{
    protected $table = 'likeartievides'; 
    protected $fillable = ['userid', 'codevides'];
    public $timestamps = true;
}
