<?php

namespace App\Controllers;

class IndexController extends TwigController 
{
    public function index()
    {
        $this->twig->display('home.html.twig');
    }
}