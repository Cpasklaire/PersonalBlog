<?php

namespace App\Controllers;

use App\Lib\DatabaseConnection;
use App\Models\UserModel;

class UserController {

    /*login function*/
    public function log() {

        if(
            (isset($_POST['email']) && $_POST['email'] !== "" && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) && 
            (isset($_POST['mdp']) && $_POST['mdp'] !== "") && preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $_POST['mdp'])
        ) {
            $email = $_POST['email'];
            $mdp = "" . $_POST['mdp'] . "";
            
            $userModel = new UserModel();
            $userModel->connection = new DatabaseConnection();
            
            $user = $userModel->login($email, $mdp);
            
            if(sizeof($user) > 0) {
                session_start();
                $_SESSION['name'] = $email;
                $_SESSION['pseudo'] = $user[1];
                $_SESSION['auth'] = "true";
                $_SESSION['userId'] = $user[0];
            } 

            header('Location: /blog_php');
            
        } else {
            
            header('Location: /blog_php');
            
        }
        
    }
        
    /*user logout*/
    public function logout() {

        session_start();
        
        $_SESSION = array();

        session_destroy();

        header('Location: /blog_php');

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
            $userModel->connection = new DatabaseConnection();
            
            $success = $userModel->createUser($pseudo, $email, $mdp);
            
            if($success) {
                echo 'utilisateur créé';
            } else {
                header('Location: /blog_php');
            }
        } else {
            
            header('Location: /blog_php');
            
        }
        
    }

    /*send email*/
    public function sendMail() {

        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $userModel = new UserModel();
        $success = $userModel->sendMail($pseudo, $email, $message);

        if($success) {

        } else {

        }

    }

}