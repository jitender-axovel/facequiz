<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizTemplate extends Model
{
    use SoftDeletes;
	protected $dates = ['deleted_at'];

	protected $fillable = [
        'name', 'category_id', 'og_image', 'html_data', 'total_images', 'total_textareas', 'has_title', 'has_image_caption'
    ];

    public static $updatable = ['name' => "", 'category_id' => "", 'og_image' => "", 'html_data' => "", 'total_images' => "", 'total_textareas' => "", 'has_title' => "", 'has_image_caption' => ""];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
}
