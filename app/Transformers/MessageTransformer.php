<?php

namespace App\Transformers;

use App\Message;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class MessageTransformer extends TransformerAbstract
{

	/**
	 * List of resources possible to include
	 *
	 * @var  array
	 */
	protected $availableIncludes = [ 'sender' ];

	/**
	 * List of resources to automatically include
	 *
	 * @var  array
	 */
	protected $defaultIncludes = [ 'receiver' ];

	/**
	 * Transform object into a generic array
	 *
	 * @var  object
	 * @return array
	 */
	public function transform(Message $message)
	{

		return [
			'subject' => $message->subject,
			'body'    => $message->body
		];
	}

	public function includeSender(Message $message)
	{

		return $this->item($message->sender, new UserTransformer());
	}

	public function includeReceiver(Message $message)
	{

		return $this->item($message->receiver, new UserTransformer());
	}
}
