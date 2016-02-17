<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'link'
    ];

    /**
     * Get the user this bookmark belongs to.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the tags of this bookmark.
     */
    public function tags() {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
