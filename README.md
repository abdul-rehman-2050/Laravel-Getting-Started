# Laravel-Getting-Started
This repository is all about cheat sheets and notes for building Laravel projects



## Instalation Related 
* [Composer](https://getcomposer.org/Composer-Setup.exe)


## Usefull Commands

```
0- composer global require "laravel/installer"   # via laravel installer
0.1- laravel new blog  #if installer is used
1- composer create-project laravel/laravel your-project-name    # Creating new project 
2- php artisan serve   # Running PHP Server
3- php artisan serve --port=8080   # Listen to specific port
4- php artisan key:generate   #generating application key

```


### Routes

``` php

//Most Basic Laravel Route
Route::get('foo', function () {
    return 'Hello World';
});

//naming a route
Route::get('user/profile', function () {
    //
})->name('profile');

//naming a route passed to a function of controller
Route::get('user/profile', 'UserController@showProfile')->name('profile');

//Access those name in generatinga url or redirecting to it 
// Generating URLs...
$url = route('profile');
$url = route('profile', ['id' => 1]);//with parameters in route

// Generating Redirects...
return redirect()->route('profile');



/*Available Router Methods
The router allows you to register routes that respond to any HTTP verb:*/

Route::get($uri, $callback);
Route::post($uri, $callback);
Route::put($uri, $callback);
Route::patch($uri, $callback);
Route::delete($uri, $callback);
Route::options($uri, $callback);


//Multipe Http Request 

Route::match(['get', 'post'], '/', function () {
    //
});

//Or respond to any http request with same route
Route::any('foo', function () {
    //
});

//Route with optional parameter with default value
Route::get('user/{name?}', function ($name = null) {
    return $name;
});

//parameter validation via regular expression
Route::get('user/{name}', function ($name) {
    //
})->where('name', '[A-Za-z]+');

Route::get('user/{id}', function ($id) {
    //
})->where('id', '[0-9]+');

Route::get('user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

//accept parameter via route
Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});

//accept more then one parameter in routes
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
});

//To protect any route via auth just add middleware 
Route::get('profile', 'UserController@show')->middleware('auth');

//Get request to specific Method of controller
Route::get('photos/popular', 'PhotoController@method');

//Register a controller to route
Route::resource('tags', 'TagController');


//You may register many resource controllers at once by passing an array to the resources method
Route::resources([
    'photos' => 'PhotoController',
    'posts' => 'PostController'
]);

//API Resource Routes

Route::apiResource('photo', 'PhotoController');


//Naming Resource Routes 

Route::resource('photo', 'PhotoController', ['names' => [
    'create' => 'photo.build'
]]);

//Redirect route from here to there via redirect method
Route::redirect('/here', '/there', 301);

/*shortcut to just return a view */
Route::view('/welcome', 'welcome');

/*view method via parameter*/
Route::view('/welcome', 'welcome', ['name' => 'Taylor']);

//prefix a route group
Route::prefix('admin')->group(function () {
    Route::get('users', function () {
        // Matches The "/admin/users" URL
    });
});


```


### [Controllers](https://laravel.com/docs/5.5/controllers)

```php

//Generating a controller via command prompt, resource parameter will add all required resource functions

php artisan make:controller TagController --resource

/*If you are using route model binding and would like the resource controller's methods to type-hint a model instance, you may use the --model option when generating the controller:*/

php artisan make:controller PhotoController --resource --model=Photo


//handle route request in controller

if ($request->route()->named('profile')) {
        //
 }

//getting an input field value from request
 $name = $request->input('name');
 
 //The is method allows you to verify that the incoming request path matches a given pattern.
 if ($request->is('admin/*')) {
    //
}

//checking request method
$method = $request->method();

if ($request->isMethod('post')) {
    //
}
 
 
//request all input data as an array from request
$input = $request->all();

//default value in case if value is not preset in request
$name = $request->input('name', 'Sally');

//Determining If An Input Value Is Present
if ($request->has('name')) {
    //
}
//checking multiple values at same time
if ($request->has(['name', 'email'])) {
    //
}

//if value is present in request and also not empty
if ($request->filled('name')) {
    //
}

//request data validation

 $validatedData = $request->validate([
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
    ]);

```

### Views

```html

<!-- Display Larvel data in blade html -->

<h1>Hello, {{ $name }}</h1>


<!-- Handling any returned errors to the view -->
<h1>Create Post</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

```

### CSRF Protection
Any HTML forms pointing to POST, PUT, or DELETE routes that are defined in the web routes file should include a CSRF token field. Otherwise, the request will be rejected. You can read more about CSRF protection in the [CSRF documentation](https://laravel.com/docs/5.5/csrf):

```html
<form method="POST" action="/profile">
    {{ csrf_field() }}
    ...
</form>

```



### Sessions

```php
//regenerate session id
$request->session()->regenerate();

// Storing data in session Via a request instance...
$request->session()->put('key', 'value');

// Via the global helper...
session(['key' => 'value']);

//flash status in session 
$request->session()->flash('status', 'Task was successful!');

//delete one key data from session
$request->session()->forget('key');

//delete all data from session
$request->session()->flush();

```
