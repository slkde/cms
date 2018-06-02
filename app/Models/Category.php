<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function article(){
        return $this->hasMany('article');
    }

    public function getparent(){
        return $this->belongsTo(Category::class,'pid');
    }
}
