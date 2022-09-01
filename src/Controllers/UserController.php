<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController {

    //users show
    public function userList() {
        $userId = $_SESSION['userId'];
        $admin = $_SESSION['admin'];
        if (!$userId) {
            header('Location: /login');
            exit();
        } elseif ($admin == 0){
            header('Location: /');
            exit();
        } else {
            $userModel = new UserModel();
            $users = $userModel->getUsers();
            echo $this->twig->render('./admin/userList.html.twig', ['users' => $users]);	
        }
    }

    //email
/*     public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $userId = $this->getCurrentUserId();
            if (!$userId) {
                if (isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['message'])) {
                    $to = 'absinthe_lafeeverte@hotmail.fr';
                    $pseudo = $_POST['pseudo'];
                    $subject = 'un mail de' .$pseudo;
                    $message = $_POST['message'];
                    $contact = $_POST['email'];
                    $headers = 'From:' .$contact;
                    
                    $success = mail(
                        $to,
                        $subject,
                        $message,
                        $headers
                    );

                    if ($success) {
                        header('Location: /'); 
                    }else{
                        echo $pseudo;
                    }
                } else {
                    echo 'formulaire vide';    
                };

            } else {
                if (isset($_POST['message'])) {
                    
                    $to = 'absinthe_lafeeverte@hotmail.fr';
                    $pseudo = $_SESSION['pseudo'];
                    $subject = 'un mail de' .$pseudo;
                    $message = $_POST['message'];
                    $contact = $_SESSION['email'];
                    $headers = 'From:' .$contact;
                    
                    $success = mail(
                        $to,
                        $subject,
                        $message,
                        $headers
                    );

                    if ($success) {
                        header('Location: /'); 
                    }else{
                        echo $pseudo;
                    }
                } else {
                    echo 'formulaire vide';    
                };

            };
        
        } else {
            return $this->render('contact.html.twig');
        }
    } */

         public function contact() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
                ini_set('SMTP', 'smtp.gmail.com');
                ini_set('smtp_port', 587);
                ini_set('sendmail_from', 'sasha.leroux92@gmail.com');
                ini_set('sendmail_path', "\"C:\wamp64\sendmail\sendmail.exe\" -t");
            $dest = "clea.leroux@hotmail.com";
            $sujet = "Email de test";
            $corp = "Salut ceci est un email de test envoyer par un script PHP";
            $headers = "From: sasha.leroux92@gmail.com";
            if (mail($dest, $sujet, $corp, $headers)) {
              echo "Email envoyé avec succès à $dest ...";
            } else {
              echo "Échec de l'envoi de l'email...";
            }
        } else {
            return $this->render('contact.html.twig');
        }
    } 
}