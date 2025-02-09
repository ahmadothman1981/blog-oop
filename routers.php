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