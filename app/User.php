<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the tags of this user.
     */
    public function tags() {
        return $this->hasMany('App\Tag');
    }

    /**
     * Get the bookmarks of this user.
     */
    public function bookmarks() {
        return $this->hasMany('App\Bookmark');
    }
}
