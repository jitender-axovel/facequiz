<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';

    protected $fillable = ['category_id', 'title', 'slug', 'description'];

    public static $updatable = ['category_id' => "", 'title' => "", 'description' => ""];

    public function parentCategory()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function quizzes()
    {
    	return $this->hasMany('App\Quiz', 'category_id');
    }
}
