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
$router->get('/contact', 'Base#contact'); //no test
$router->post('/contact', 'Base#contact'); //no test
$router->get('/info', 'Base#politique');

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
$router->get('/admin/articles/:id', 'Post#showAdmin')->with('id', '[0-9]+');
$router->post('/admin/modify/:id', 'Post#modify')->with('id', '[0-9]+');
$router->get('/admin/modify/:id', 'Post#modify')->with('id', '[0-9]+');
$router->get('/admin/delete/:id', 'Post#delete')->with('id', '[0-9]+');
$router->get('/admin/createPost', 'Post#create');
$router->post('/admin/createPost', 'Post#create');
//comment
$router->get('/admin/commentaires', 'Comment#showComments'); 
$router->get('/admin/commentaires/:id', 'Comment#validate')->with('id', '[0-9]+');
$router->post('/admin/commentaires/delect/:id', 'Comment#deleteComment')->with('id', '[0-9]+'); //no test
//user
$router->get('/admin/users', 'Base#userList');

try {
    $router->run();
}catch(\Exception $e){
    die ($e);
}