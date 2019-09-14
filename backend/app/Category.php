<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categories';

    public function scopePopular($query)
    {
        return $query->where('isActivate', '=', 1);
    }
    
    public function tags() {
        return $this->hasMany('App\Tag');
    }
}
