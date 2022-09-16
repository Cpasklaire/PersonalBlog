<?php

namespace App\Router;

//Create routes
class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }
    
    //add route whith GET method to all routes
    public function get(string $path, $callable, $name = NULL) 
    {
        return $this->addRoute($path, $callable, $name, 'GET');
    }
    
    //add route whith POST method to all routes
    public function post(string $path, $callable, $name = NULL) 
    {
        return $this->addRoute($path, $callable, $name, 'POST');
    }
    
    //create and add route to routes array
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
    
    //Check if road exist and if matche with $routes
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
/*                 if (strpos($this->url, '/admin') == 0) {
                    // TODO SAM
                    // faut etre admin
                    // si on est pas admin -> 401
                    // return $request->redirect('/login');
                    throw new \Exception(401);
                    
                }    */          
               // check the route permissions (est-ce qu il faut etre admin ?)
               // si il faut eter admin et qu on ne l'est pas -> 401 ou redirect  /
               return $route->call();
                
            }
        }
        throw new RouterException('No routes matches');
    }

     //check url and call getUrl
    public function url($name, $params = []) 
    {
        if(!isset($this->namedRoutes[$name])) 
        {
            //throw new RouterException('No route match this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    } 
}