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
                        // TODO SAM
                        /* $_SESSION['userId'] = $user->id;
                        $_SESSION['admin'] = $user->admin;
                        $_SESSION['pseudo'] = $user->pseudo; */

                        $request->setSession('userId', $user->id);
                        $request->setSession('admin', $user->admin);
                        $request->setSession('pseudo', $user->pseudo);                        

                        if ($user->admin == 1) {
                            header('Location: /admin'); // change to redirect avec le return devant ... 
                            die;
                        }
                        header('Location: /'); // ideam
                    }
                    header('Location: /error');                    
                }
                header('Location: /error');                
            }
            return $request->redirect('/error');            
            
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
                    // TO DO SAM les redirect
                    header('Location: /login');
                    die;
                }
                header('Location: /signup');
                die;
            }

            header('Location: /error');
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
