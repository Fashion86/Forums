<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discusstion extends Model
{
    public function posts() {
        return $this->hasMany('App\post', 'discusstion_id', 'id');
    }
}
