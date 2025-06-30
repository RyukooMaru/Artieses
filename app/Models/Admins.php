<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'adminid';
    protected $fillable = ['userid', 'activity', 'bio', 'email'];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(Users::class, 'userid', 'userid');
    }
}
