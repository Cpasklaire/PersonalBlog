<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController {

    //users show
    public function userList() {

        $user = $this->getCurrentUser();

        if (!$user->id) {
            header('Location: /login');
        } elseif ($user->admin == 0){
            header('Location: /');
        } else {
            $userModel = new UserModel();
            $users = $userModel->getUsers();
            $this->twig->render('./admin/userList.html.twig', ['users' => $users]);	
        }
    }

    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

            $userId = $this->getCurrentUserId();
            $request = new RequestController();
            $message = $request->post['message'];

            if (!$userId) {
                    $pseudo = $request->post['pseudo'];
                    $contact = $request->post['email'];
            } else {
                $user = $this->getCurrentUser();
                $pseudo = $user->pseudo;
                $contact = $user->email;
            }
            if (isset($message)) {

                $headers = 'From:' .$contact;
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