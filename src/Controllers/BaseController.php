<?php

namespace App\Controllers;

use App\Models\UserModel;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Models\PostModel;

class BaseController
{

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
        } else {
            $userModel = new UserModel();
            $user = $userModel->getUser($userId);
            return $user;
        }
    }

    protected function getCurrentUserId()
    {
        if (isset($_SESSION['userId']) && (int)$_SESSION['userId'] > 0) {
            return $_SESSION['userId'];
        } else {
            return null;
        }
    }

    protected function isAuthenticated()
    {
        return $this->getCurrentUserId() > 0 ? true : false;
    }

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
