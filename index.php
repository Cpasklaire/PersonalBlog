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
$router->get('/articles', 'Post#list');
$router->get('/articles/:id', 'Post#show')->with('id', '[0-9]+');

//$router->post('/articles/postComment/:id-:userId', 'Comment#createComment')->with('id', '[0-9]+')->with('userId', '([a-zA-Z\-0-9])+');
//$router->post('/articles/:id/comment/:commentId', 'Comment#update')->with('id', '[0-9]+')->with('commentId', '([a-zA-Z\-0-9])+');
//$router->post('/articles/:id/commentDelete/:commentId', 'Comment#delete')->with('id', '[0-9]+')->with('commentId', '([a-zA-Z\-0-9])+');

try {
$router->run();
}catch(\Exception $e){
    die ($e);
}