<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/14/15
 * Time: 22:10
 */

namespace App\Exceptions;


use Exception;

class ApiException extends Exception
{

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $status;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $detail;

	/**
	 * Get the status
	 *
	 * @return int
	 */
	public function getStatus()
	{

		return (int)$this->status;
	}

	/**
	 * Return the Exception as an array
	 *
	 * @return array
	 */
	public function toArray()
	{

		return [
			'id'     => $this->id,
			'status' => $this->status,
			'title'  => $this->title,
			'detail' => $this->detail
		];
	}

	/**
	 * Build the Exception
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected function build(array $args)
	{

		$this->id = array_shift($args);

		$error = config(sprintf('errors.%s', $this->id));

		$this->title = $error['title'];
		$this->detail = vsprintf($error['detail'], $args);

		return $this->detail;
	}
}