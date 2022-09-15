<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController {

    //user connection

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $request = new RequestController();
            $login = $request->post['login'];
            $password = $request->post['password'];

            if (isset($login) && isset($password)) {
                $userModel = new UserModel();
                $user = $userModel->login($login);

                //user existe
                if ($user) {

                    //good password
                    if (password_verify($password, $user->mdp)) {

                        //$user->id = $request->session['userId'];
                        //$password = $request->post['password'];
                        $_SESSION['userId'] = $user->id;
                        $_SESSION['admin'] = $user->admin;
                        $_SESSION['pseudo'] = $user->pseudo;
                        if ($user->admin == 1) {
                            header('Location: /admin');
                        } else {
                            header('Location: /');
                        }
                    } else {
                        header('Location: /login?error=invalid_passeword');
                    }
                } else {
                    header('Location: /login?error=invalid_credentials');
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
            $request = new RequestController();
            $pseudo = $request->post['pseudo'];
            $email = $request->post['email'];
            $password = $request->post['password'];

            if (isset($pseudo) && isset($email) && isset($password)) {
                $userModel = new UserModel();
                $success = $userModel->createUser($pseudo, $email, $password);

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
