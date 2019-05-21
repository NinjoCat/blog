<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    const STATUS = ['ACTIVE' => 1, 'INACTIVE' => 0];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
