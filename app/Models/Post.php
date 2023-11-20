<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable=['name','id','description','content','cat_id'];

//    protected $with = ['category'];

    public function category()
    {
        return $this->hasOne(PostCategory::class,'id','cat_id');
    }


}
