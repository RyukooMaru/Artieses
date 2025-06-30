<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComVides extends Model
{
    protected $table = 'commentartievides'; 
    protected $primaryKey = 'commentartievidesid';
    protected $fillable = ['userid', 'codevides', 'commentses'];
    public $timestamps = true;
}
