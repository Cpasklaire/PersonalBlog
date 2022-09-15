<?php

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Models\PostModel;
use App\Models\UserModel;

class BaseController {
    
    private $loader;
    protected $twig;

    //Render twig
    public function __construct()
    {
        $this->loader = new FilesystemLoader('./templates');
        $this->twig = new Environment($this->loader);
    }

    //User connected
    protected function getCurrentUser()
    {
        $userId = $this->getCurrentUserId();

        if (!$userId) {
            return null;
        }

        $userModel = new UserModel();
        $user = $userModel->getUser($userId);
        return $user;
    }

    protected function getCurrentUserId()
    {
        $request = new RequestController();
        echo $userId = $request->session['userId'];
        echo $userId;

        if (isset($userId) && (int)$userId > 0) {
            return $userId;
        }

        return null;
    }

    protected function isAuthenticated()
    {
        return $this->getCurrentUserId() > 0 ? true : false;
    }

/*     protected function isAdmin()
    {
        $request = new RequestController();
        $request->session;

        $userId = $session['userId'];
        $admin = $session['admin'];
        if (!$userId) {
            header('Location: /login');
        } elseif ($admin == 0) {
            header('Location: /');
        }
    }  */

    //render function
    protected function render($view, $params = [])
    {
        $params['currentUser'] = $this->getCurrentUser();
        $this->twig->display($view, $params);
    }

    public function index()
    {
        $postModel = new PostModel();
        $posts = $postModel->getPosts();

        $this->render('home.html.twig', ['posts' => $posts]);
    }

    public function politique()
    {
        $this->render('polConf.html.twig');
    }
}
