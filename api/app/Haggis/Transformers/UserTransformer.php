<?php

namespace App\Haggis\Transformers;

use App\Haggis\Transformers\Transformer;

class UserTransformer extends Transformer {
	/**
	* transform a single user for proper API output
	* 
	* @param  [type] $user [description]
	* @return [type]       [description]
	*/
	public function transform($user)
	{
		return [
		    'id' => (int) $user['id'],
		    'name' => $user['name'],
		    'email' => $user['email']
		];
	}
}