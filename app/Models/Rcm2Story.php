<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rcm2Story extends Model
{
    protected $table = 'rcm2story';
    protected $primaryKey = 'rcm2storyid';
    public $incrementing = true;
    protected $fillable = ['userid', 'balcomstoriesid', 'reaksi'];
    public $timestamps = true;
}
