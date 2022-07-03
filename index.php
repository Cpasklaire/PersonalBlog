<?php

echo "hello word";

require 'vendor/autoload.php';

$router = new App\Router\Router($_GET['url']);

//$router->get();

//$router->post();

$router->run();