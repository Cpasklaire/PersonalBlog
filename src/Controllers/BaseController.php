<?php 

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class BaseController {
	
	private $loader;
	protected $twig;

	public function __construct() {
		$this->loader = new FilesystemLoader('./templates');
        $this->twig = new Environment($this->loader);        
	}

    public function index()
    {
        $this->twig->display('home.html.twig');
    }

}