<?php

//si dev 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* phpinfo();
die; */

require 'vendor/autoload.php';

define('ROOT', dirname(__DIR__));

$router = new App\Router\Router($_SERVER['REQUEST_URI']);

$router->get('/PersonalBlog/', 'Index#index');

$router->get('/Post', 'Post#list');
$router->get('/post/:id', 'Post#show')->with('id', '[0-9]+');
/* echo 'index'; */

try {
$router->run();
}catch(\Exception $e){
    die ($e);
}