<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	
    protected $fillable = ['name', 'code', 'fb_code', 'fb_like', 'direction', 'strings'];

    public static $updatable = ['name' => "", 'code' => "", 'fb_code' => "", 'fb_like' => "", 'direction' => "", 'strings' => ""];
}
