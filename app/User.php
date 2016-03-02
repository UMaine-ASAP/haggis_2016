<?php

namespace App;

use Illuminate\Http\Request;
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
    	return $this->belongsToMany('App\Project', 'projects_users', 'user_id', 'project_id');
    }


    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function assignments() 
    {
        return $this->belongsToMany('App\Assignment', 'assignments_users', 'user_id', 'assignment_id');
    }

    /**
     * relationship
     *
     * @return [type] [description]
     */
    public function classes()
    {
        return $this->belongsToMany('App\Classes', 'classes_users', 'user_id', 'class_id');
    }
 

    /**
     * rules for user validation based on the type of request
     * 
     * @return [type] [description]
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|between:4,30',
            'website' => 'url',
            'first_name' => 'required|alpha_dash',
            'last_name' => 'required|alpha_dash',
            'middle_initial' => 'alpha|between:0,1',
        ];
        
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': 
            {
                return [];
            }
            case 'POST': 
            {
                return [
                    'email' => 'required|email',
                    'password' => 'required|between:4,30',
                    'website' => 'url',
                    'first_name' => 'required|alpha_dash',
                    'last_name' => 'required|alpha_dash',
                    'middle_initial' => 'alpha|between:0,1',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'email' => 'required|email',
                    'password' => 'required|between:4,30',
                    'website' => 'url',
                    'first_name' => 'required|alpha_dash',
                    'last_name' => 'required|alpha_dash',
                    'middle_initial' => 'alpha|between:0,1',
                ];
            }

            default: break;

        }

    }
}