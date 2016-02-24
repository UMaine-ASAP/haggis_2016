<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'assignments';

    /**
     * Primary key for this table
     * 
     * @var string
     */
    protected $primaryKey = "assignment_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];
}
