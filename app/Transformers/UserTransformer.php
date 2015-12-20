<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/13/15
 * Time: 16:42
 */

namespace App\Transformers;


use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

	/**
	 * @param User $user
	 *
	 * @return array
	 */
	public function transform(User $user)
	{

		return [
			'id'   => (int)$user->id,
			'name' => $user->name
		];
	}
}