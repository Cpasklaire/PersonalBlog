<?php

require 'vendor/autoload.php';

$router = new App\Router\Router($_GET['url']);

$router->get('/', function(){ require('templates/home.php'); });
$router->get('/articles', 'Post#list');
$router->get('/articles/:id', 'Post#show')->with('id', '[0-9]+');

$router->run();