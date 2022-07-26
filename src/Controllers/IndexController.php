<?php

namespace App\Controllers;

class IndexController extends BaseController 
{
    public function index()
    {
        // get 3 posts
        $this->twig->display('home.html.twig', ['posts' => []]);
    }
}