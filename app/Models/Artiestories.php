<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\ReactStories;
use App\Models\ComStories;

class Artiestories extends Model
{
    protected $table = 'artiestories'; 
    protected $primaryKey = 'artiestoriesid';
    protected $fillable = ['userid', 'coderies', 'caption', 'lseo', 'kseo', 'deltime'];
    public $timestamps = true;
    public function usericonStories()
    {
        return $this->belongsTo(Users::class, 'userid', 'userid');
    }
    public function reactStories()
    {
        return $this->hasMany(ReactStories::class, 'artiestoriesid', 'artiestoriesid');
    }
    public function comments()
    {
        return $this->hasMany(ComStories::class, 'coderies', 'coderies');
    }
    public function commentscount()
    {
        return $this->hasMany(ComStories::class, 'coderies', 'artiestoriesid');
    }
    public function images() {
        return $this->hasMany(ArtiestoriesIMG::class, 'artiestoriesid');
    }
    public function user()
    {
        return $this->belongsTo(Users::class, 'userid', 'userid');
    }
    
}
