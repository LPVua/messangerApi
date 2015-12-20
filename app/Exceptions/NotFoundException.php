<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/14/15
 * Time: 22:13
 */

namespace App\Exceptions;


class NotFoundException extends ApiException
{

	/**
	 * @var string
	 */
	protected $status = '404';

	/**
	 * NotFoundException constructor.
	 */
	public function __construct()
	{

		$message = $this->build(func_get_args());

		parent::__construct($message);
	}
}