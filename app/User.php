<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','phone','role','balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   const AUTHOR_TYPE = 'author';
    const ADMIN_TYPE = 'admin';

    public function isAuthor($value='')
    {
        return  $this->role === self::AUTHOR_TYPE;
    } 

    public function isAdmin($value='')
    {
        return $this->role === self::ADMIN_TYPE;
    }

    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
