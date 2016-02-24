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
}
