<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Primary key for this table
     * 
     * @var string
     */
    protected $primaryKey = "user_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'middle_initial', 'email', 'website', 'user_type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function classes() 
    {
    	return $this->hasMany('App\Classes');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function evaluations() 
    {
    	return $this->hasMany('App\Evaluation');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function projects() 
    {
    	return $this->belongsToMany('App\Project', 'projects_users');
    }
}