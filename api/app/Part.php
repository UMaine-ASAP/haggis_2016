<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'parts';

    /**
     * Primary key for this table
     * 
     * @var string
     */
    protected $primaryKey = "part_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];
}
