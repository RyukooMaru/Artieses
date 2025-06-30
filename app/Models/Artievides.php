<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;


class Artievides extends Model
{
    protected $table = 'artievides'; 
    protected $primaryKey = 'artievidesid';
    public $incrementing = true;
    protected $fillable = ['userid', 'codevides', 'judul', 'lseo', 'kseo', 'video','thumbnail', 'deltime'];
    public $timestamps = true;
    public function usericonVides()
    {
        return $this->belongsTo(Users::class, 'userid', 'userid');
    }
    public function subscribervides()
    {
        return $this->hasMany(Subs::class, 'subscriber');
    }
    public function likeVides()
    {
        return $this->hasMany(likevides::class, 'codevides', 'codevides');
    }
    public function banyakviewyahemangiyah()
    {
        return $this->hasMany(ViewVideskahjagoluklobisangambilini::class, 'codevides', 'codevides');
    }
}