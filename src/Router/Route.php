<?php

namespace App\Router;

class Route {

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable) 
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    public function with(string $param,string $regex) 
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }
    
    public function match(string $url): bool 
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'] , $this->path);
        $regex = "#^$path$#i";

        if (!preg_match($regex, $url, $matches)) 
        {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }
    
    private function paramMatch($match): string 
    {
        if(isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function call() 
    {
        if(is_string($this->callable)) {
            $params = explode('#', $this->callable);
            
            $controller = "App\\Controllers\\" . $params[0] . "Controller";
            $ctrl = new $controller();
            
            return call_user_func_array([$ctrl, $params[1]], $this->matches);
        }else 
        {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function getUrl($params): string 
    {
        $path = $this->path;

        foreach($params as $id => $value) 
        {
            $path = str_replace(':$id', $value, $path);
        }
        return $path;
    }
}