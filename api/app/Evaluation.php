<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'evaluations';

    /**
     * Primary key for this table
     * 
     * @var string
     */
    protected $primaryKey = "evaluation_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['criterion_id', 'rating', 'comment', 'evaluator_id'];
}
