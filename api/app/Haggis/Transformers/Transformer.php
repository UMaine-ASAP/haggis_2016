<?php

namespace App\Haggis\Transformers;

abstract class Transformer {
	 /**
     * transform an array of users for proper API output
     * 
     * @param  [type] $users [description]
     * @return [type]        [description]
     */
    public function transformCollection(array $items) 
    {
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);
}