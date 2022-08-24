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

/*     protected function adminProtect() {
        $userId = $_SESSION['userId'];
        
        if (!$userId) {
            header('Location: /admin', true, 'Location: /');
            exit();
        } else {
        }
    } */

    public function index()
    {
        $this->render('home.html.twig');
    }    
    public function politique()
    {
        $this->render('polConf.html.twig');
    } 

    protected function render($view, $params = [])
    {
        $params['currentUser'] = $this->getCurrentUser();
        $this->twig->display($view, $params);
    }

    public function contact()
    {
        $this->render('contact.html.twig');
    } 

    public function userList() {
        $userModel = new UserModel();
        $users = $userModel->getUsers();
        echo $this->twig->render('./admin/userList.html.twig', ['users' => $users]);	
    }
}