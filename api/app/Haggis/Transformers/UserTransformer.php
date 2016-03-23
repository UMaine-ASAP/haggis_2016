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
		    'id' => (int) $user['user_id'],
		    'first_name' => $user['first_name'],
		    'last_name' => $user['last_name'],
		    'middle_initial' => $user['middle_initial'],
		    'email' => $user['email'],
		    'website' => $user['website']
		];
	}
}