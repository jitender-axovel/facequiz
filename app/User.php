<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fb_id', 'name', 'slug', 'email', 'user_role_id', 'password', 'gender', 'dob', 'avatar',
    ];

    public static $downloadable = ['fb_id' => "", 'name' => '', 'slug' => '', 'email' => '', 'user_role_id' => '', 'password' => '', 'gender' => '', 'dob' =>'', 'avatar' => ''];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\UserRole', 'user_role_id', 'id');
    }

    public function isAdmin()
    {
        return ($this->user_role_id == 1);
    }
}
