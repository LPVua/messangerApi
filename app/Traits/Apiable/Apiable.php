<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 29.09.15
 * Time: 10:56
 */

namespace App\Traits\Apiable;


trait Apiable {
	use RespondTypes;
	/**
	 * @var int
	 */
	protected $statusCode = 200;

	/**
	 * @return mixed
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * @param $statusCode
	 *
	 * @return $this
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	/**
	 * @param       $data
	 * @param array $headers
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respond($data, $headers = [])
	{
		return response()->json($data, $this->getStatusCode(), $headers);
	}

	/**
	 * @param $message
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respondWithError($message)
	{
		return $this->respond([
			'error' => [
				'message'     => $message,
				'status_code' => $this->getStatusCode()
			]
		]);
	}

	public function respondWithData($data, array $additional = [])
	{
		$result = [
			'data' => $data
		];
		$result = array_merge($result, $additional);

		return $this->respond($result);
	}
}