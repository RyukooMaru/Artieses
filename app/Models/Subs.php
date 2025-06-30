<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subs extends Model
{
    protected $table = 'subs'; 
    protected $primaryKey = 'subsid';
    protected $fillable = ['subscriber', 'subscribing'];
    public $timestamps = true;
    public function subscriberUser()
    {
        return $this->belongsTo(Users::class, 'subscriber', 'userid');
    }

    // Relasi ke user yang di-subscribe
    public function subscribingUser()
    {
        return $this->belongsTo(Users::class, 'subscribing', 'userid');
    }
}
