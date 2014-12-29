<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/* first mode */
Route::get('/', 'HomeController@index');

/* second mode
Route::get('users', 'users@index');
*/

Route::get('users', function()
{
	$users = User::all();
	return View::make('users')->with('users',$users);
});


/* third mode */
Route::get('test', function(){
	return View::make('test');
});

Route::post('submit', function(){
	if(Input::hasFile('photo')){

		$file = Input::file('photo');

		// multiple files submitted
		if(is_array($file))
		{
			foreach($file as $part) {
				$filename = $part->getClientOriginalName();
				$part->move($destinationPath, $filename);
			}
		}
		else //single file
		{
			$filename = $file->getClientOriginalName();
			$uploadSuccess = Input::file('photo')->move($destinationPath, $filename);
		}

	} else {
		echo 'Error: no file submitted.';
	};
	if (Input::has('name')){
		// $name = Input::get('name');
		// $address = Input::get('address');
		// return $name.' and '.$address;
		//return Redirect::to('/');

		$input = Input::all();
		// Flashing Input to the Session
		// Input::flash();
		// return Redirect::to('/')->withInput();
		// return $input['name'].' and '.$input['address'];
		return View::make('success')->with('input',$input);

	}
	else {
		return Redirect::to('/');
	}
});

/*********************************

	View Composer

*********************************/

View::composer('layout', function($view){
	$users = User::all();
	$view->with(compact('users'));
});


/********************************

	Responses

********************************/

Route::get('json', function(){
	return Response::json(array(
		'name' => 'Renato Kano',
		'old' => 30,
		'address' => 'Av. Liberdade, 959',
		'married' => true));
});

/*********************************

	Cookies

*********************************/

Route::get('cookieset', function()
{
	$foreverCookie = Cookie::forever('forever', 'Success');
	$tempCookie = Cookie::make('temporary', 'Temporary', 1);
	return Response::make()->withCookie($foreverCookie)->withCookie($tempCookie);
});


Route::get('cookietest', function()
{
	$forever = Cookie::get('forever');
	$temporary = Cookie::get('temporary');
	return View::make('cookietest', array('forever' => $forever, 'temporary' => $temporary, 'variableTest' => 'works'));
});


/*********************************

	Route Parameters Studies

**********************************/

//Route::get('user/{id}', function($id){
//	return 'User '.$id;
//});

// Optional Route Parameters
//Route::get('user/{name?}', function($name = null){
//	return 'User '.$name;
//});

// Optional Route Parameters Default
//Route::get('user/{name?}', function($name = 'Renato'){
//	return 'User '.$name;
//});

// Regular Expressions Route Constraints
//Route::get('user/{name}', function($name){
//	return 'user.name is: '.$name;
//})->where('name','[A-Za-z]+');

//Route::get('user/{id}', function($id){
//	return 'user.id is: '.$id;
//})->where('id','[0-9]+');

// Passing An Array of Wheres
//Route::get('user/{id?}/{name?}', function($id=null,$name=null){
//	return 'user.id: '.$id.' and user.name: '.$name;
//})->where(array(
//	'id' => '[0-9]+',
//	'name' => '[A-Za-z]+',
//));

// Defining Global Patterns
//Route::pattern('id','[0-9]+');
//Route::get('user/{id}', function($id){
//	return 'user.id:'.$id;
//});

// Accessing a Route Parameter Value
// ????
//Route::filter('foo', function(){
//	if(Route::input('id') == 1){
//		return 'Olá Renato Kano!!!';
//	}
//});


/*********************************

	Route Filters Studies

**********************************/

// Defining a Route Filter
Route::filter('old',function(){
	if(Input::get('age') < 200){
		return Redirect::to('/');
	}
});

// Attaching a Filter to a Route
//Route::get('user',array('before' => 'old', function(){
//	return 'You are over 200 years old!';
//	}
//));

// Attaching a Filter to a Controller Action
//Route::get('user',array('before' => 'old', 'uses' => 'users@index'));

// Attaching Multiple Filters to a Route
// Route::get('user', array('before' => 'auth | old', function(){
// 		return 'You are authenticated and over 200 years old!';
// }));

// Attaching Multiple Filters Via Array
// Route::get('user', array('before' => array('auth', 'old'), function(){
// 	return 'You are authenticated and over 200 years old!';
// }));

// Specifying Filter Parameter
// ?????
// Route::filter('age', function($route,$request,$value){
// 	if($value < 200){
// 		return Redirect::to('/');
// 	}
// });
// Route::get('user',array('before' => 'age:200', function(){
// 	return 'Hello!';
// }));


// Registering A Class Based Filter
Route::filter('foo','FooFilter');

class FooFilter {
	public function filter(){
		if(Input::get('age') < 200){
			// redirect with flash data (session) -> use Session::get method to retrieve data
			return Redirect::to('/')->with('message','Você é Juvenal!');
		}
	}
};

Route::get('user',array('before' => 'foo', function(){
	return 'OK';
}));


/********************************

	Named Routes

********************************/

Route::get('user/profile', array('as' => 'profile', 'uses' => 'users@index'));


/********************************

	Route Groups

********************************/

Route::group(array('before' => 'auth'), function(){
	Route::get('admin', function(){
		return 'Admin';
	});
	Route::get('sitemap', function(){
		return 'Sitemap';
	});
});


/*********************************

	Sub-Domain Routing

*********************************/

Route::group(array('domain' => '{account}.bluelabs.com'), function(){
	Route::get('user/{id}', function($account, $id){
		return $account.' and '.$id;
	});
});

/*********************************

	Route Model Binding

*********************************/

Route::model('user','User',function(){
	App::abort(404);
});

Route::get('profile/{user}', function(User $user){
	return 'Olá '.$user['name'];
});
