<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 29.09.15
 * Time: 11:07
 */

namespace App\Traits\Apiable;


trait RespondTypes {

	/**
	 * @param string $message
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respondNotFound($message = 'Not found')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	/**
	 * @param string $message
	 * @param array $additional
	 * @return mixed
	 */
	public function respondSuccess($message, array $additional = [])
	{
		$result = [
			'success' => [
				'message'     => $message,
				'status_code' => $this->getStatusCode()
			]
		];
		$result = array_merge($result, $additional);

		return $this->setStatusCode(200)->respond($result);
	}

	public function respondPaginatedData($data, $pagination)
	{
		return $this->setStatusCode(200)->respondWithData($data, [
			'meta' => [
				'pagination' => $pagination
			]
		]);
	}
}