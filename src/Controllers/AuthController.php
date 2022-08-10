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

                if($_SESSION['admin']==1) {   
                    header('Location: /admin');
                    die;
                } else {
                    header('Location: /');    
                    die;
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
        return $this->render('sign.html.twig');
    }
}