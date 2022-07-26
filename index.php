<?php

//si dev 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* phpinfo();
die; */

require 'vendor/autoload.php';


$router = new App\Router\Router($_SERVER['REQUEST_URI']);

//$router->get('/', 'Index#index');

$router->get('/', 'Index#index');
$router->get('/posts', 'Post#list');
//$router->get('/post/:id', 'Post#show')->with('id', '[0-9]+');

try {
$router->run();
}catch(\Exception $e){
    die ($e);
}