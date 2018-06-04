<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\District;
class Article extends Model
{
    //
    protected $guarded = [];


    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function setUpdatedAt($value)
	{
		return null;
	}

	public function getUpdatedAtColumn()
    {
        return null;
    }
}
