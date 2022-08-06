<?php

//si dev 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* phpinfo();
die; */

require 'vendor/autoload.php';


$router = new App\Router\Router($_SERVER['REQUEST_URI']);

$router->get('/', 'Index#index');
$router->get('/articles', 'Post#list');
$router->get('/articles/:id', 'Post#show')->with('id', '[0-9]+');

//$router->post('/articles/postComment/:id-:userId', 'Comment#createComment')->with('id', '[0-9]+')->with('userId', '([a-zA-Z\-0-9])+');
//$router->post('/articles/:id/comment/:commentId', 'Comment#update')->with('id', '[0-9]+')->with('commentId', '([a-zA-Z\-0-9])+');
//$router->post('/articles/:id/commentDelete/:commentId', 'Comment#delete')->with('id', '[0-9]+')->with('commentId', '([a-zA-Z\-0-9])+');

$router->post('/log', 'User#log');
$router->post('/sign', 'User#sign');
$router->post('/logout', 'User#logout');
$router->post('/contact', 'User#sendMail');

$router->post('/adminlog', 'Admin#log');

$router->get('/adminPanel/showarticles', 'Admin#list');
$router->get('/adminPanel/modify/:id', 'Admin#show');
$router->post('/adminPanel/modify/:id', 'Admin#modify');
$router->post('/adminPanel/delete/:id', 'Admin#delete');
$router->post('/adminPanel/addarticle', 'Admin#create');
$router->get('/adminPanel/showComments', 'Admin#showComments');
$router->post('/adminPanel/articles/:id/commentDelete/:commentId', 'Admin#deleteComment')->with('id', '[0-9]+')->with('commentId', '([a-zA-Z\-0-9])+');
$router->post('/adminPanel/validateComment/:id', 'Admin#validate');

try {
$router->run();
}catch(\Exception $e){
    die ($e);
}