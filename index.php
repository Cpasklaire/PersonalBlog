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
$router->get('/', 'Base#index'); //ok
$router->get('/articles', 'Post#list'); //ok
$router->get('/articles/:id', 'Post#show')->with('id', '[0-9]+'); //bug
$router->post('/contact', 'User#sendMail'); //no test


// Render method in base controller
// auth controller

//connection
$router->get('/login', 'Auth#login'); //ok
$router->post('/login', 'Auth#login'); //bug
$router->get('/sign', 'Auth#sign'); //ok
$router->post('/sign', 'User#sign'); //bug
$router->post('/logout', 'User#logout'); //no test

//user
// userId n'est pas dans l'URL ! 
// standard REST /articles/:id/comment en POST
$router->post('/articles/postComment/:id-:userId', 'Comment#createComment')->with('id', '[0-9]+')->with('userId', '([a-zA-Z\-0-9])+'); //no test

// admin
// admin base controller qui verifie que l'utilisateur est admin ... 

//posts
$router->get('/admin', 'Post#listAdmin'); //ok
// /admin/post/:id en post (pour edit / create) en delete pour le delete 
$router->post('/admin/modify/:id', 'Post#modify'); //no test
$router->post('/admin/delete/:id', 'Post#delete'); //no test
$router->post('/admin/creatpost', 'Post#create'); //no test

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