<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

	protected $fillable = [ 'from', 'to', 'subject', 'body' ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function sender()
	{

		return $this->belongsTo(User::class, 'from');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function receiver()
	{

		return $this->belongsTo(User::class, 'to');
	}
}
