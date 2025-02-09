<?php
namespace App\Middlewares;

use Core\Router;
use Core\Middleware;
use App\Services\Auth as ServiceAuth;


class Auth implements Middleware
{
    public function handle(callable $next)
    {
        $user = ServiceAuth::user();
        if(!$user)
        {
            Router::unauthorized();
        }
        return $next();
    }
}