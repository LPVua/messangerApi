<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
Route::group([ 'prefix' => 'api' ], function ()
{

	/*
	|--------------------------------------------------------------------------
	|  API V1
	|--------------------------------------------------------------------------
	*/
	Route::group([ 'prefix' => 'v1' ], function ()
	{

		/*
		|--------------------------------------------------------------------------
		|  USERS ROUTES
		|--------------------------------------------------------------------------
		*/
		Route::group([ 'prefix' => 'users' ], function ()
		{

			get('', 'UsersController@getAll');
			post('', 'UsersController@createUser');
			/*
			|--------------------------------------------------------------------------
			|  USER ROUTES
			|--------------------------------------------------------------------------
			*/
			Route::group([ 'prefix' => '{user_id}' ], function ()
			{

				put('', 'UsersController@editUser');
				get('', 'UsersController@getById');

				/*
				|--------------------------------------------------------------------------
				|  USER MESSAGES ROUTES
				|--------------------------------------------------------------------------
				*/
				Route::group([ 'prefix' => 'messages' ], function ()
				{

					get('', 'MessagesController@getAllUserMessages');
				});
			});
		});

		/*
		|--------------------------------------------------------------------------
		|  MESSAGES ROUTES
		|--------------------------------------------------------------------------
		*/
		Route::group([ 'prefix' => 'messages' ], function ()
		{
			post('', 'MessagesController@createMessage');
			/*
			|--------------------------------------------------------------------------
			|  MESSAGE ROUTES
			|--------------------------------------------------------------------------
			*/
			Route::group([ 'prefix' => '{message_id}' ], function ()
			{

				get('', 'MessagesController@getMessage');
				patch('', 'MessagesController@changeSubject');
				put('', 'MessagesController@updateMessage');
			});
		});
	});
});



