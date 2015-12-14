<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/14/15
 * Time: 21:30
 */

namespace App\Http\Controllers;


use App\Exceptions\Messages\ReceiverNotFoundException;
use App\Exceptions\Messages\SenderNotFoundException;
use App\Http\Requests\CreateMessageRequest;
use App\Message;
use App\Traits\Apiable\Apiable;
use App\Transformers\MessageTransformer;
use App\User;
use Cyvelnet\Laravel5Fractal\Facades\Fractal;

class MessagesController extends Controller
{

	use Apiable;

	public function getAllUserMessages()
	{

		$messages = Message::paginate(20);

		return $this->respond(Fractal::collection($messages, new MessageTransformer()));
	}

	public function createMessage(CreateMessageRequest $request)
	{
		$sender = User::find($request->get('sender')['id']);
		if (!$sender)
		{
			throw new SenderNotFoundException('messages_sender_not_found');
		}
		$receiver = User::find($request->get('receiver')['id']);
		if (!$receiver)
		{
			throw new ReceiverNotFoundException('messages_receiver_not_found');
		}

		$message = Message::create($request->only([ 'subject', 'body' ]));
		$message->sender()->associate($sender);
		$message->receiver()->associate($receiver);

		return $this->respondSuccess('Message sent!', [ 'message' => Fractal::item($message, new MessageTransformer)->getArray() ]);
	}
}