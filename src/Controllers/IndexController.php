<?php

namespace App\Controllers;

class IndexController extends TwigController 
{
    public function index()
    {
        echo ('là');
        $this->twig->display('home.html.twig');
    }
}