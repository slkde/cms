<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Article;

class Image extends Model
{
    //
    public function article(){
        return $this->belongsTo(Article::class);
    }
}
