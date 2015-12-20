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
use App\Exceptions\NotFoundException;
use App\Http\Requests\CreateMessageRequest;
use App\Message;
use App\Traits\Apiable\Apiable;
use App\Transformers\MessageTransformer;
use App\User;
use Cyvelnet\Laravel5Fractal\Facades\Fractal;
use Illuminate\Http\Request;

class MessagesController extends Controller
{

	use Apiable;

	/**
	 * @param $user_id
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getAllUserMessages($user_id)
	{

		$messages = Message::where('from', $user_id)->paginate(20);

		return $this->respond(Fractal::collection($messages, new MessageTransformer())->getArray());
	}

	/**
	 * @param CreateMessageRequest $request
	 *
	 * @return mixed
	 * @throws ReceiverNotFoundException
	 * @throws SenderNotFoundException
	 */
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
		$message->save();

		return $this->respondSuccess('Message sent!', [ 'message' => Fractal::item($message, new MessageTransformer)->getArray() ]);
	}

	/**
	 * @param         $message_id
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws NotFoundException
	 */
	public function changeSubject($message_id, Request $request)
	{

		$this->validate($request, [
			'subject' => 'required'
		]);

		if ($message = Message::find($message_id))
		{
			$message->update($request->get('subject'));

			return $this->respondSuccess('Subject successfully updated', [ 'message' => Fractal::item($message, new MessageTransformer()) ]);
		}
		throw new NotFoundException;
	}
}