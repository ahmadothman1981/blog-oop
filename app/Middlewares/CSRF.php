<?php 
namespace App\Middlewares;
use Core\Router;
use Core\Middleware;
use App\Services\CSRF as ServiceCSRF;



class CSRF implements Middleware
{
    public function handle(callable $next)
    {
        if(!ServiceCSRF::verify())
        {
           Router::pageExpired(); 
        }
        return $next();
    }
}