<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name'
    ];

    /**
     * Get the user this tag belongs to.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the bookmarks of this tag.
     */
    public function bookmarks() {
        return $this->belongsToMany('App\Bookmark')->withTimestamps();
    }
}
