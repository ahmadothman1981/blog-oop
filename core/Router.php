<?php

namespace Core;

class Router
{
    protected array $routes = [];
    public function add(string $method , string $uri , string $controller): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    public function notFound():string
    {
        http_response_code(404);
        echo '404 | Not Found';
        exit;
    }
    public function dispatch(string $uri , string $method): string
    {
        $route = $this->findRoute($uri , $method);
        if(!$route)
        {
            return $this->notFound();
        }
        [$controller , $action] = explode('@' , $route['controller']);
        return $this->callAction($controller , $action , $route['params']);
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
}