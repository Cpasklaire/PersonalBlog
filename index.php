<?php

//si dev 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* phpinfo();
die; */

require 'vendor/autoload.php';

session_start();

$router = new App\Router\Router($_SERVER['REQUEST_URI']);

//global
$router->get('/', 'Base#index');
$router->get('/articles', 'Post#list');
$router->get('/articles/:id', 'Post#show')->with('id', '[0-9]+');
$router->post('/contact', 'User#sendMail'); //no test

//connection
$router->get('/login', 'Auth#login');
$router->post('/login', 'Auth#login');
$router->get('/signup', 'Auth#signup');
$router->post('/signup', 'Auth#signup');
$router->get('/logout', 'Auth#logout');

//user
$router->post('/articles/:id/comment/', 'Comment#createComment')->with('id', '[0-9]+'); //no test

// admin
//posts
$router->get('/admin', 'Post#listAdmin'); 
// /admin/post/:id en post (pour edit / create) en delete pour le delete 
$router->post('/admin/modify/:id', 'Post#modify'); //no test
$router->post('/admin/delete/:id', 'Post#delete'); //no test
$router->get('/admin/createPost', 'Post#create');
$router->post('/admin/createPost', 'Post#create');
//comment
$router->get('/admin/commentaires', 'Comment#showComments'); //bug
$router->post('/admin/articles/:id/commentDelete/:commentId', 'Comment#deleteComment')->with('id', '[0-9]+')->with('commentId', '([a-zA-Z\-0-9])+'); //no test
$router->post('/admin/commentaires/validate/:id', 'Comment#validate'); //no test
//user
$router->get('/admin/users', 'User#list');

try {
    $router->run();
}catch(\Exception $e){
    die ($e);
}