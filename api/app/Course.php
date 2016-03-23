<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

    /**
     * Primary key for this table
     * 
     * @var string
     */
    protected $primaryKey = "course_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'code', 'description'];

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function classes()
    {
        return $this->belongsToMany('App\Class', 'courses_classes', 'course_id', 'class_id');
    }
}
