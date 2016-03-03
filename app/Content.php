<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contents';

    /**
     * Primary key for this table
     * 
     * @var string
     */
    protected $primaryKey = "content_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'format', 'size', 'lcoation'];

    /**
     * relationship
     * 
     * @return [type] [description]
     */
    public function parts()
    {
        return $this->belongsToMany('App\Part', 'contents_parts', 'content_id', 'part_id');
    }
}
