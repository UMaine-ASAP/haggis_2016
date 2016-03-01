<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * Primary key for this table
     *
     * @var string
     */
    protected $primaryKey = "project_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'assignment_id'];

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'projects_users', 'user_id', 'project_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function assignments()
    {
        return $this->belongsToMany('App\Assignment', 'assignments_projects', 'assignment_id', 'project_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function parts()
    {
        return $this->belongsToMany('App\Part', 'parts_projects', 'project_id', 'part_id');
    }
}
