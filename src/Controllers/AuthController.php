<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController {
    
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
            // Perform authentication
            if (isset($_POST['login']) && isset($_POST['password'])) {                
                $userModel = new UserModel();                
                $user = $userModel->login($_POST['login'], $_POST['password']);
                if ($user) {
                    $_SESSION['userId'] = $user->id;
                } else {
                    // invalid credentials or user does not exist
                    header('Location: /login?error=invalid_credentials');    
                    die;
                }

                if(password_verify($_POST['password'], $user->mdp)) {
                    if($user->admin==1) {   
                        header('Location: /admin');
                        die;
                    } else {
                        header('Location: /');    
                        die;
                    }
                } else {
                    header('Location: /login?error=invalid_passeword'); 
                }
           } else {
                // invalid credentials : missing data in form
                header('Location: /login?error=invalid_form');    
            }
         } else {
            // Render authentication form
            return $this->render('login.html.twig');
        }        
    }

    public function sign()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  

            

            if (isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['password'])) {                
                $userModel = new UserModel();                
                $success = $userModel->createUser($_POST['pseudo'], $_POST['email'], $_POST['password']);
                if($success) {
                    echo 'utilisateur créé';
                    header('Location: /login');
                } else {
                    header('Location: /sign');
                }
           } else {
                header('Location: /signin?error=invalid_form');    
            }
         } else {
            return $this->render('sign.html.twig');
        }   
    }

     public function logout() {

        session_start();
        session_destroy();

        header('Location: /');

    } 
}