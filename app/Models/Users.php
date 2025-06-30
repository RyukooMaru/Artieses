<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Users extends Model 
{
    protected $table = 'users';
    protected $primaryKey = 'userid';
    protected $fillable = ['username', 'nameuse', 'bio', 'email', 'password','improfil','editusername','deleteaccount'];
    public $timestamps = true;

    public function stories()
    {
        return $this->hasMany(Artiestories::class, 'userid', 'userid');
    }

    public function videos()
    {
        return $this->hasMany(Artievides::class, 'userid', 'userid');
    }

    public function artiekeles()
    {
        return $this->hasMany(Artiekeles::class, 'userid', 'userid');
    }

    public function subscribing()
    {
        return $this->hasMany(Subs::class, 'subscriber', 'userid');
    }
    public function subscriber()
    {
        return $this->hasMany(Subs::class, 'subscribing', 'userid');
    }
    public function admin()
    {
        return $this->hasOne(Admins::class, 'userid', 'userid');
    }
    // Jika Anda mengimplementasikan Illuminate\Contracts\Auth\Authenticatable,
    // Anda perlu metode-metode berikut:
    /*
    public function getAuthIdentifierName()
    {
        return 'userid';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['userid'];
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    public function getRememberToken()
    {
        return $this->attributes['remember_token'] ?? null; // Sesuaikan jika tidak ada remember_token
    }

    public function setRememberToken($value)
    {
        $this->attributes['remember_token'] = $value; // Sesuaikan jika tidak ada remember_token
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Sesuaikan jika tidak ada remember_token
    }
    */
}