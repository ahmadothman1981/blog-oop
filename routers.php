<?php

use App\Middlewares\Auth;
use App\Middlewares\CSRF;
use App\Middlewares\View;
/**
 * @var Core\Router $router
 */
$router->addGlobalMiddleware(View::class);
$router->addRouteMiddleware('auth', Auth::class);
$router->addGlobalMiddleware(CSRF::class);

$router->add('GET', '/' , 'HomeController@index');
$router->add('GET','/posts' , 'PostController@index');
$router->add('GET','/posts/{id}' , 'PostController@show');
$router->add('POST','/posts/{id}/comments' , 'CommentController@store',['auth']);
$router->add('GET','/login' , 'authController@create');
$router->add('POST','/login' , 'authController@store');
$router->add('POST','/logout' , 'authController@destroy');

//======Admin Panel routes
$router->add('GET','/admin/dashboard' , 'Admin\DashboardController@index', ['auth']);
$router->add('GET','/admin/posts' , 'Admin\PostController@index', ['auth']);
$router->add('GET','/admin/post/create' , 'Admin\PostController@create', ['auth']);
$router->add('POST','/admin/posts' , 'Admin\PostController@store', ['auth']);
$router->add('GET','/admin/post/{id}/edit' , 'Admin\PostController@edit', ['auth']);
$router->add('POST','/admin/posts/{id}' , 'Admin\PostController@update', ['auth']);
$router->add('POST','/admin/post/{id}/delete' , 'Admin\PostController@destroy', ['auth']);

