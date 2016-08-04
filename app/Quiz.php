<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['category_id', 'sub_category_id', 'quiz_template_id', 'title', 'slug', 'locale', 'background_image', 'description', 'total_facts', 'show_own_profile_picture', 'show_user_name', 'show_friend_pictures', 'show_friend_name', 'is_active'];

    public static $updatable = ['category_id' => "", 'sub_category_id' => "", 'quiz_template_id' => "", 'title' => "", 'slug' => "", 'locale' => "", 'background_image' => "", 'description' => "", 'total_facts' => "", 'show_own_profile_picture' => "", 'show_user_name' => "", 'show_friend_pictures' => "", 'show_friend_name' => "", 'is_active' => ""];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }

    public function subCategory()
    {
    	return $this->belongsTo('App\SubCategory');
    }

    public function template()
    {
    	return $this->belongsTo('App\QuizTemplate', 'quiz_template_id', 'id');
    }
    
    public function facts()
    {
        return $this->hasMany('App\QuizFact');
    }
}
