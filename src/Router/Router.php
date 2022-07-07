<?php

namespace App\Router;

use App\Controllers\PostController;

class Router 
{
    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }
    
    public function get(string $path, $callable, $name = NULL) 
    {
        return $this->addRoute($path, $callable, $name, 'GET');
    }

    public function post(string $path, $callable, $name = NULL) 
    {
        return $this->addRoute($path, $callable, $name, 'POST');
    }

    public function addRoute(string $path, $callable, $name, string $method) 
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;

        if(is_string($callable) && $name === null)
        {
            $name = $callable;
        }
        if($name) 
        {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run() 
    {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])) 
        {
            throw new RouterException('No routes exist');
        } 
        
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route) 
        {   
            if($route->match($this->url)) 
            {
                return $route->call();
            } 
        }
        throw new RouterException('No routes matches');
    }

    public function url($name, $params = []) 
    {
        if(!isset($this->namedRoutes[$name])) 
        {
            throw new RouterException('No route match this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}