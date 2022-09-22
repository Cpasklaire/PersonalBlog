<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController {

    //user connection

    public function connect()
    {
        $request = new \App\Request();
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
                        $request->setSession('userId', $user->id);
                        $request->setSession('admin', $user->admin);
                        $request->setSession('pseudo', $user->pseudo);

                        if ($user->admin == 1) {
                            return $request->redirect('/admin');
                        }
                        return $request->redirect('/');
                    }
                    return $request->redirect('/error');
                }
                return $request->redirect('/error');
            }
            return $request->redirect('/error');
            
        }
        return $this->render('login.html.twig');
    }

    //create user
    public function signup()
    {
        $request = new \App\Request();
        $method = $request->server['REQUEST_METHOD'];

        if ($method === 'POST') {
            
            $pseudo = $request->post['pseudo'];
            $email = $request->post['email'];
            $password = $request->post['password'];

            if (isset($pseudo) && isset($email) && isset($password)) {
                $userModel = new UserModel();
                $success = $userModel->createUser($pseudo, $email, $password);
                if ($success) {
                    return $request->redirect('/login');
                }
                return $request->redirect('/signup');
            }
            return $request->redirect('/error');
        }
        return $this->render('signup.html.twig');
    }

    //deconnection
    public function logout()
    {
        $request = new \App\Request();
        session_destroy();
        return $request->redirect('/');
    }
}
