<?php

namespace App\Controllers;

use App\Models\PostModel;

class IndexController extends BaseController 
{
    public function index()
    {
        $this->twig->display('home.html.twig');
    }
}