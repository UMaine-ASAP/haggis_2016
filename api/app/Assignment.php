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

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function criteria()
    {
        return $this->belongsToMany('App\Criterion', 'assignments_criteria', 'assignment_id', 'criterion_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function parts()
    {
        return $this->belongsToMany('App\Part', 'assignments_parts', 'assignment_id', 'part_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function projects()
    {
        return $this->belongsToMany('App\Project', 'assignments_projects', 'assignment_id', 'part_id');
    }

}
