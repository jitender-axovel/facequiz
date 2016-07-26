<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizAttempt extends Model
{
    use SoftDeletes;
	protected $dates = ['deleted_at'];

	protected $fillable = ['user_id', 'quiz_id', 'result_image'];

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function quiz()
	{
		return $this->belongsTo('App\Quiz');
	}
}
