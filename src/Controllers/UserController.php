<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController {

    //users show
    public function userList() {

        $user = $this->getCurrentUser();

        //$userId = $_SESSION['userId'];
        //$admin = $_SESSION['admin'];
        
        if (!$user->id) {
            header('Location: /login');
            exit();
        } elseif ($user->admin == 0){
            header('Location: /');
            exit();
        } else {
            $userModel = new UserModel();
            $users = $userModel->getUsers();
            $this->twig->render('./admin/userList.html.twig', ['users' => $users]);	
        }
    }

    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

            $userId = $this->getCurrentUserId();

            if (!$userId) {
                    $pseudo = $_POST['pseudo'];
                    $contact = $_POST['email'];
            } else {
                $user = $this->getCurrentUser();
                $pseudo = $user->pseudo;
                $contact = $user->email;
            }
            if (isset($_POST['message'])) {

                $headers = 'From:' .$contact;
                $message = $_POST['message'];
                $destinataire = 'sasha.leroux92@gmail.com';
                $sujet = "Email de" .$pseudo;

                if (mail($destinataire, $sujet, $message, $headers)) {
                    header('Location: /');
                } else {
                    header('Location: /contact');
                }
            }
        }
        return $this->render('contact.html.twig');
    } 
}