<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

	protected $fillable = [ 'from', 'to', 'subject', 'body' ];

	public function sender()
	{

		return $this->belongsTo(User::class, 'from');
	}

	public function receiver()
	{

		return $this->belongsTo(User::class, 'to');
	}
}
