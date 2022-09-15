<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController {

    //user connection

    public function connect()
    {
        $request = new RequestController();
        $method = $request->server['REQUEST_METHOD'];

        if ($method === 'POST') {
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
                        }
                        header('Location: /');
                    }
                    header('Location: /error');
                    echo 1;
                }
                header('Location: /error');
                echo 2;
            }
            header('Location: /error');
            echo 3;
        }
        return $this->render('login.html.twig');
    }

    //create user
    public function signup()
    {
        $request = new RequestController();
        $method = $request->server['REQUEST_METHOD'];

        if ($method === 'POST') {
            
            $pseudo = $request->post['pseudo'];
            $email = $request->post['email'];
            $password = $request->post['password'];

            if (isset($pseudo) && isset($email) && isset($password)) {
                $userModel = new UserModel();
                $success = $userModel->createUser($pseudo, $email, $password);

                if ($success) {
                    header('Location: /login');
                }
                header('Location: /signup');
            }

            header('Location: /error');
            echo 1;
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
