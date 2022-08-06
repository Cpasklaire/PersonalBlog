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

	protected function isAuthenticated() {
		return $this->getCurrentUserId() > 0 ? true : false;
	}

	protected function getCurrentUser() {
		// TODO get current user from db and return it
		return null;  
	}

	protected function getCurrentUserId() {
		if (isset($_SESSION['userId']) && (int)$_SESSION['userId'] > 0) return $_SESSION['userId'];
		return null;
	}

}