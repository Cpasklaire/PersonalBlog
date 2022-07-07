<?php

namespace App\Controllers;

use Twig/FilesystemLoader;
use Twig/Environment;

abstract class TwigController 
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(TOOT.'/templates');
        $this->twig = new Environment($this->loader);
    }
}