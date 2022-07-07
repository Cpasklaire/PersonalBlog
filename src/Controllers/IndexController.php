<?php

namespace App\Controllers;

class MainController extends TwigController 
{
    public function index()
    {
        $this->twig->display('home.html.twig');
    }
}