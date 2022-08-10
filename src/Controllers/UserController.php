<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController {

    /*login*/
    public function login() {

        if(
            (isset($_POST['email']) && $_POST['email'] !== "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && 
            (isset($_POST['mdp']) && $_POST['mdp'] !== "") && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['mdp'])
        ) {
            $email = $_POST['email'];
            $mdp = "" . $_POST['mdp'] . "";
            
            $userModel = new UserModel();
            
            $user = $userModel->login($email, $mdp);
            
            if(sizeof($user) > 0) {
                session_start();
                $_SESSION['userId'] = $user[0];
                $_SESSION['pseudo'] = $user[1];
                $_SESSION['name'] = $email;
                $_SESSION['admin'] = $user[4];
            } 

            if($_SESSION['admin']==0)
            {
            header('Location: /');      
        } else if($_SESSION['admin']==1) 
        {   
            header('Location: /admin');
        }else{
            header('Location: /inconnu');
        }     
    }}
        
    /*user logout*/
    public function logout() {

        session_start();
        
        $_SESSION = array();

        session_destroy();

        header('Location: /');

    }

    /*create an user account*/
    public function sign() {

        if(
            (isset($_POST['email']) && $_POST['email'] !== "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) &&
            (isset($_POST['mdp']) && $_POST['mdp'] !== "") && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['mdp']) &&
            (isset($_POST['pseudo']) && $_POST['pseudo'] !== "" && preg_match('/^[a-zA-Zé èà]*$/', $_POST['pseudo']))
        ) {

            
            $email = $_POST['email'];
            $mdp = "" . $_POST['mdp'] . "";
            $pseudo = $_POST['pseudo'];
            
            $userModel = new UserModel();
            
            $success = $userModel->createUser($pseudo, $email, $mdp);
            
            if($success) {
                echo 'utilisateur créé';
            } else {
                header('Location: /sign');
            }
        } else {
            
            header('Location: /');
            
        }
        
    }


    /*send email
    public function sendMail() {

        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $userModel = new UserModel();
        $success = $userModel->sendMail($pseudo, $email, $message);

        if($success) {

        } else {

        }

    }*/

}