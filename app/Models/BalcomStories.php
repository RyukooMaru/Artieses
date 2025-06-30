<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Rcm2Story;

class BalcomStories extends Model
{
    protected $table = 'balcomstories'; 
    protected $primaryKey = 'balcomstoriesid';
    protected $fillable = ['userid', 'commentartiestoriesid', 'comment'];
    public $timestamps = true;
    public function userBalcom()
    {
        return $this->belongsTo(Users::class, 'userid', 'userid');
    }
    public function rcm2()
    {
        return $this->hasMany(Rcm2Story::class, 'balcomstoriesid', 'balcomstoriesid');
    }
}
