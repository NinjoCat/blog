<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function rubric()
    {
        return $this->belongsTo('App\Rubric');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'posttag');
    }

    public function revisions()
    {
        return $this->hasMany('App\Revision');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
