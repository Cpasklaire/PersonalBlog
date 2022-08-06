<?php

namespace App\Controllers;

use App\Models\PostModel;

class IndexController extends BaseController 
{
    public function index()
    {
        // get 3 posts
        $postModel = new PostModel();
        // $postModel->connection = new DatabaseConnection();
        $posts = $postModel->getPosts();
        $this->twig->display('home.html.twig', ['posts' => $posts]);
    }

    public function login()
    {
        // TODO : if already connected, move to home ... we should not see the login form when already logged in
        if ($this->isAuthenticated()) {
            header("Location: /");
            die();
        }        
        $this->twig->display('login.html.twig');
    }

    public function authenticate()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        if ($login == 'sam' && $password == 'password') {
            // TODO check for real user in db
            $_SESSION["userId"]= 1;
            header("Location: /");
            die();
        } else {
            header("Location: /login");
            die();
        }
    }
}