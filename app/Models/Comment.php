<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Article;

class Comment extends Model
{
    //

    protected $guarded = [];
    
    public function article(){
        return $this->belongsTo(Article::class);
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
