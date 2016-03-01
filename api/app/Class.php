<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Class extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classes';

    /**
     * Primary key for this table
     * 
     * @var string
     */
    protected $primaryKey = "class_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_id', 'title', 'description', 'start_time', 'location'];

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'classes_users', 'class_id', 'user_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course', 'courses_classes', 'class_id', 'course_id');
    }

}
