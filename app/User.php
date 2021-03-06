<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const MODERATOR_TYPE = 'moderator';
    const DEFAULT_TYPE = 'default';

    public function isAdmin()    {

        return $this->type === self::ADMIN_TYPE;

    }

    public function isModerator()    {

        return $this->type === self::MODERATOR_TYPE;

    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function story()
    {

        $this->hasMany('App\Story');

    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function chat()
    {

        return $this->hasMany('App\Chat');

    }
}
