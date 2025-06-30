<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReactStories extends Model
{
    protected $table = 'reactartiestories'; 
    protected $primaryKey = 'reactartiestoriesid';
    protected $fillable = ['userid', 'artiestoriesid', 'reaksi'];
    public $timestamps = true;

}
