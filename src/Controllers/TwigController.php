<?php

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class TwigController 
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        echo (ROOT);
        $this->loader = new FilesystemLoader(ROOT.'/PersonalBlog/templates');
        $this->twig = new Environment($this->loader);
    }
}