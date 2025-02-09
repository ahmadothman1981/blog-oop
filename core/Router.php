<?php

namespace Core;

class Router
{
    protected array $routes = [];
    protected array $globalMiddleware = [];
    protected array $routeMiddleware = [];
    public function add(string $method , string $uri , string $controller , array $middlewares = []): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller ,
            'middlewares' => $middlewares
        ];
    }
    public function addGlobalMiddleware(string $middleware): void
    {
        $this->globalMiddleware[] = $middleware;
    }
    public function addRouteMiddleware(string $name , string $middleware): void
    {
        $this->routeMiddleware[$name] = $middleware;
    }

    public static function notFound():string
    {
        http_response_code(404);
        echo View::render('errors/404');
        exit;
    }
    public static function pageExpired():string
    {
        http_response_code(419);
        echo View::render('errors/419');
        exit;
    }
    public static function unauthorized():string
    {
        http_response_code(401);
        echo View::render('errors/401');
        exit;
    }
    public function dispatch(string $uri , string $method): string
    {
        $route = $this->findRoute($uri , $method);
        if(!$route)
        {
            return static::notFound();
        }
        $middlewares = [
            ...$this->globalMiddleware,
            ...array_map(fn($name) => $this->routeMiddleware[$name] , $route['middlewares'])
        ];
        return $this->runMiddleware($middlewares ,
        function() use ($route) {
            [$controller , $action] = explode('@' , $route['controller']);
        
        return $this->callAction($controller , $action , $route['params']);
        });
    }
    protected function runMiddleware(array $middlewares ,callable $target): mixed
    {
        $next = $target;
        foreach(array_reverse($middlewares) as $middleware)
        {
            $next = fn()=>(new $middleware)->handle($next);   
             
        }
        return $next();
    }
    protected function findRoute(string $uri , string $method): ?array
    {
        //find the route that match the uri and method
        foreach($this->routes as $route)
        {
            $params = $this->matchRoute($route['uri'] , $uri);
            if($params !== null && $route['method'] === $method)
            {
                return [...$route ,'params' => $params];
            }
        }
        return null;
    }
    protected function matchRoute(string $routeUri , string $requestUri):?array 
    { 
        //copare route uri and request uri
        $routeSegaments = explode('/' , trim($routeUri , '/'));
        $requestSegaments = explode('/' , trim($requestUri , '/'));
        if(count($routeSegaments) !== count($requestSegaments)){
            return null;
        }

        $params = [];

        foreach($routeSegaments as $index => $routeSegament)
        {
            if(str_starts_with($routeSegament , '{') && str_ends_with($routeSegament , '}'))
            {
                $params[trim($routeSegament , '{}')] = $requestSegaments[$index];
            }elseif($routeSegament !== $requestSegaments[$index])
            {
                return null;
            }
        }

        return $params;
        
    }
    protected function callAction(string $controller ,string $action , array $params): string 
    {
        //namespace of the class then create a new class by using variable 
        //action is  a method of the class controler 
       $controllerClass = "App\\Controller\\$controller";
       return (new $controllerClass)->$action(...$params); 
    }
    public static function redirect(string $uri):void
    {
        header("Location: {$uri}"); 
        exit;
    }
}