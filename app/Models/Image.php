<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Article;

class Image extends Model
{
    //

    public $timestamps = false;

    protected $guarded = [];
    
    public function article(){
        return $this->belongsTo(Article::class);
    }

}
