<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/13/15
 * Time: 16:27
 */

namespace App\Http\Controllers;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserEditRequest;
use App\Traits\Apiable\Apiable;
use App\Transformers\UserTransformer;
use App\User;
use Cyvelnet\Laravel5Fractal\Facades\Fractal;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{

	use Apiable;

	public function getAll()
	{

		$users = User::paginate(20);

		return $this->respond(Fractal::collection($users, new UserTransformer())->getArray());
	}

	public function getById($user_id)
	{

		if ($user = User::find($user_id))
		{
			return $this->respond(Fractal::item($user, new UserTransformer())->getArray());
		}
		throw new NotFoundHttpException;
	}

	public function createUser(CreateUserRequest $request, User $user)
	{

		$user = $user->create($request->all());

		return $this->respondSuccess('User successfully created!', [
			'user' => Fractal::item($user, new UserTransformer())->getArray()
		]);
	}

	public function editUser($user_id, UserEditRequest $request)
	{

		if ($user = User::find($user_id))
		{
			$user->update($request->all());
			return $this->respondSuccess('User was successfully updated',['user' => Fractal::item($user, new UserTransformer())->getArray()]);
		}
		throw new NotFoundHttpException;
	}
}