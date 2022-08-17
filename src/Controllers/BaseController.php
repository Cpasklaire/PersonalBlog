<?php 

namespace App\Controllers;

use App\Models\UserModel;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class BaseController {
	
	private $loader;
	protected $twig;

	public function __construct() {
		$this->loader = new FilesystemLoader('./templates');
        $this->twig = new Environment($this->loader);        
	}

     protected function getCurrentUser() {		
        $userId = $this->getCurrentUserId();
        if (!$userId) return null;
        $userModel = new UserModel();
        $user = $userModel->getUser($userId);
		return $user;
	}	
    
    protected function getCurrentUserId() {
		if (isset($_SESSION['userId']) && (int)$_SESSION['userId'] > 0) return $_SESSION['userId'];
		return null;
	}
    
    protected function isAuthenticated() {
		return $this->getCurrentUserId() > 0 ? true : false;
	} 

    public function index()
    {
        $this->render('home.html.twig');
    }    

    protected function render($view, $params = [])
    {
        $params['currentUser'] = $this->getCurrentUser();
        $this->twig->display($view, $params);
    }
}