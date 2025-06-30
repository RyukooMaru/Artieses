<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BalcomStories;
use App\Models\Rcm1Story;

class ComStories extends Model
{
    protected $table = 'commentartiestories'; 
    protected $primaryKey = 'commentartiestoriesid';
    protected $fillable = ['userid', 'coderies', 'commentses'];
    public $timestamps = true;
    public function userComments()
    {
        return $this->belongsTo(Users::class, 'userid', 'userid');
    }
    public function rcm1()
    {
        return $this->hasMany(Rcm1Story::class, 'commentartiestoriesid', 'commentartiestoriesid');
    }
    public function replies()
    {
        return $this->hasMany(BalcomStories::class, 'commentartiestoriesid', 'commentartiestoriesid');
    }
}
