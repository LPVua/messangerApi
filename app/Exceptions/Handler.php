<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		HttpException::class,
		ModelNotFoundException::class,
		//ApiException::class
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $e
	 *
	 * @return void
	 */
	public function report(Exception $e)
	{

		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception               $e
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($e instanceof ModelNotFoundException)
		{
			$e = new NotFoundHttpException($e->getMessage(), $e);
		}

		return $this->handle($request, $e);
		//return parent::render($request, $e);
	}

	/**
	 * Convert the Exception into a JSON HTTP Response
	 *
	 * @param Request   $request
	 * @param Exception $e
	 *
	 * @return JSONResponse
	 */
	private function handle($request, Exception $e)
	{
		if ($e instanceOf ApiException)
		{
			$data = $e->toArray();
			$status = $e->getStatus();
		} else if ($e instanceOf NotFoundHttpException)
		{
			$data = array_merge([
				'id'     => 'not_found',
				'status' => '404'
			], config('errors.not_found'));

			$status = 404;
		} else if ($e instanceOf MethodNotAllowedHttpException)
		{
			$data = array_merge([
				'id'     => 'method_not_allowed',
				'status' => '405'
			], config('errors.method_not_allowed'));

			$status = 405;
		} else
		{
			return parent::render($request, $e);
		}


		return response()->json($data, $status);
	}
}
