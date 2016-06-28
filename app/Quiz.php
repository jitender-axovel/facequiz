<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['category_id', 'sub_category_id', 'quiz_template_id', 'title', 'slug', 'background_image', 'description', 'show_own_profile_image', 'show_user_name', 'show_friend_pictures', 'show_friend_name', 'is_active'];

    public static $updatable = ['category_id' => "", 'sub_category_id' => "", 'quiz_template_id' => "", 'title' => "", 'slug' => "", 'background_image' => "", 'description' => "", 'show_own_profile_image' => "", 'show_user_name' => "", 'show_friend_pictures' => "", 'show_friend_name' => "", 'is_active' => ""];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function subCategory()
    {
    	return $this->belongsTo('App\SubCategory');
    }

    public function quizTemplate()
    {
    	return $this->belongsTo('App\QuizTemplate');
    }
}
