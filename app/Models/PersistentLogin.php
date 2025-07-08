<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersistentLogin extends Model
{
    protected $table = 'persistent_logins'; 
    protected $fillable = ['userid', 'token', 'ip_address', 'user_agent', 'expires_at'];
    public $timestamps = true;
}
