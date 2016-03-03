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

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function parts()
    {
        return $this->belongsToMany('App\Part', 'evaluations_parts', 'evaluation_id', 'part_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function projects()
    {
        return $this->belongsToMany('App\Project', 'evaluations_projects', 'evaluation_id', 'project_id');
    }

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'evaluations_users', 'evaluation_id', 'user_id');
    }
}
