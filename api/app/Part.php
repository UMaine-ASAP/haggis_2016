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

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function assignments()
    {
        return $this->belongsToMany('App\Assignment', 'assignments_parts', 'part_id', 'assignment_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function contents()
    {
        return $this->belongsToMany('App\Content', 'contents_parts', 'part_id', 'content_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function criteria()
    {
        return $this->belongsToMany('App\Criterion', 'criteria_parts', 'part_id', 'criterion_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function evaluations()
    {
        return $this->belongsToMany('App\Evaluation', 'evaluations_parts', 'part_id', 'evaluation_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function project()
    {
        return $this->belongsToMany('App\Project', 'parts_projects', 'part_id', 'project_id');
    }
}
