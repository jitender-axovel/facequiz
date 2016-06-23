<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['title', 'slug', 'description'];

    public static $updatable = ['title' => "", 'description' => ""];

    public function quizzes()
    {
    	return $this->hasMany('App\Quiz', 'category_id');
    }
}
