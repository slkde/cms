<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Article;
use DB;
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

    public static function getids($id){
        if(count(Category::find($id)->getchild)){
            return Category::select(DB::raw('GROUP_CONCAT(id) as ids'))->where('pid', $id)->groupBy('id')->get();
        }else{
            return array($id);
        }
        
    }
}
