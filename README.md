# Laravel-Getting-Started
This repository is all about cheat sheets and notes for building Laravel projects



## Usefull Links
* [Composer](https://getcomposer.org/Composer-Setup.exe)
* [Toastr Library](https://github.com/CodeSeven/toastr)
* [Preview Library](https://github.com/dusterio/link-preview)

## Usefull Commands

```
00- composer global require "laravel/installer"                  #via laravel installer
01- laravel new blog                                             #if installer is used
02- composer create-project laravel/laravel your-project-name    # Creating new project 
-----------------------------------------------------------------------------------
03- php artisan serve               # Running PHP Server
04- php artisan serve --port=8080   # Listen to specific port
05- php artisan key:generate        #generating application key
---------------------------------------------------------------------------------------
06- npm install                     # install npm components
07- npm run dev                     #compile assets
08- npm run watch                   #will automatically compile and run in background
----------------------------------------------------------------------------------------
09- php artisan preset react        #will use react instead of vue
10- php artisan preset none         #will remove all javascripts and bootstrap instead of few
11- php artisan make:migration create_users_table  #create migration from command
12- php artisan migrate --force                    # make forced migration
13- php artisan migrate:reset                   # rollback all migrations
14- php artisan migrate:refresh
15- php artisan migrate:refresh --seed
16- php artisan migrate:fresh
17- php artisan migrate:fresh --seed


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

Route::get('profile', function () {
    // Only authenticated users may enter...
})->middleware('auth');

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


### [Queries](https://laravel.com/docs/5.5/queries)

```php

$products = Product::where('name_en', 'LIKE', '%'.$search.'%')->get();

$items = Items::where('active', true)->orderBy('name')->pluck('name', 'id');    //select * from Items where 'active'=true

//single row from the table via first() method

$user = DB::table('users')->where('name', 'John')->first();

//instead of fetching whole row just fetch single value

$email = DB::table('users')->where('name', 'John')->value('email');

// get whole column 
$titles = DB::table('roles')->pluck('title');

/*
The query builder also provides a variety of aggregate methods such as count, max, min, avg, and  sum. You may call any of these methods after constructing your query:

*/

$users = DB::table('users')->count();
$price = DB::table('orders')->max('price');
$price = DB::table('orders')
                ->where('finalized', 1)
                ->avg('price');


//getting user detail via scafolded auth

use Illuminate\Support\Facades\Auth;

// Get the currently authenticated user...
$user = Auth::user();

// Get the currently authenticated user's ID...
$id = Auth::id();


//check if user is authenticated

if (Auth::check()) {
    // The user is logged in...
}

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
    

//apply middleware to controller
public function __construct()
{
    $this->middleware('auth');
}

```

### [Views](https://laravel.com/docs/5.5/blade)

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


<!-- Creating a template layout. Stored in resources/views/layouts/app.blade.php -->

<html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')
            This is the master sidebar.
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>


<!--Extending a layout Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p>This is my body content.</p>
@endsection


<!-- Looping in Blade views -->

@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
@endfor

@foreach ($users as $user)
    <p>This is user {{ $user->id }}</p>
@endforeach

@forelse ($users as $user)
    <li>{{ $user->name }}</li>
@empty
    <p>No users</p>
@endforelse

@while (true)
    <p>I'm looping forever.</p>
@endwhile

<!-- Include Subviews -->
<div>
    @include('shared.errors')

    <form>
        <!-- Form Contents -->
    </form>
</div>

<!-- adding vue component -->

@extends('layouts.app')

@section('content')
    <example-component></example-component>
@endsection



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
