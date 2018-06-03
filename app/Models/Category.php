<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Article;

class Category extends Model
{
    //
    public $table = 'categorys';
    protected $guarded = [];
    
    public function article(){
        return $this->hasMany(Article::class);
    }

    public function getparent(){
        return $this->belongsTo(Category::class,'pid');
    }

    public function getchild(){
        return $this->hasMany(Category::class,'pid');
    }
}
