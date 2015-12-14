<?php

namespace App\Http\Requests;

class CreateMessageRequest extends Request
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{

		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'sender.id'   => 'required|numeric',
			'receiver.id' => 'required|numeric',
			'subject'     => 'required|max:200',
			'body'        => 'required|max:500'
		];
	}
}
