<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{

    //user connection

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['login']) && isset($_POST['password'])) {
                $userModel = new UserModel();
                $user = $userModel->login($_POST['login']);

                //user existe
                if ($user) {
                    $_SESSION['userId'] = $user->id;
                    $_SESSION['admin'] = $user->admin;
                    $_SESSION['pseudo'] = $user->pseudo;
                } else {
                    header('Location: /login?error=invalid_credentials');
                }

                //good password
                if (password_verify($_POST['password'], $user->mdp)) {

                    if ($user->admin == 1) {
                        header('Location: /admin');
                    } else {
                        header('Location: /');
                    }
                } else {
                    header('Location: /login?error=invalid_passeword');
                }
            } else {
                header('Location: /login?error=invalid_form');
            }
        }

        return $this->render('login.html.twig');
    }

    //create user
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['password'])) {
                $userModel = new UserModel();
                $success = $userModel->createUser($_POST['pseudo'], $_POST['email'], $_POST['password']);

                if ($success) {
                    header('Location: /login');
                } else {
                    header('Location: /signup');
                }
            } else {
                header('Location: /signup?error=invalid_form');
            }
        }

        return $this->render('signup.html.twig');
    }

    //deconnection
    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
}
