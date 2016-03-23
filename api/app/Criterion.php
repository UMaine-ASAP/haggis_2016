<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'criteria';

    /**
     * Primary key for this table
     * 
     * @var string
     */
    protected $primaryKey = "criterion_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'range'];

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function assignments()
    {
        return $this->belongsToMany('App\Assignment', 'assignments_criteria', 'criterion_id', 'assignment_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function parts()
    {
        return $this->belongsToMany('App\Part', 'criteria_parts', 'criterion_id', 'part_id');
    }
}
