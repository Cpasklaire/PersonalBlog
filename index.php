<?php

echo "hello world";

require 'vendor/autoload.php';

$router = new App\Router\Router($_GET['url']);

$router->get('/', function(){ require('templates/home.php'); });

$router->get('/articles', 'Post#list');
$router->post('/log', 'User#log');
$router->post('/sign', 'User#sign');
$router->post('/logout', 'User#logout');
$router->post('/contact', 'User#sendMail');
$router->post('/adminlog', 'Admin#log');

$router->run();