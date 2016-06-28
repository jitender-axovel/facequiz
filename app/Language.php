<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name', 'code', 'fb_code', 'direction', 'strings'];

    public static $updatable = ['name' => "", 'code' => "", 'fb_code' => "", 'direction' => "", 'strings' => ""];
}
