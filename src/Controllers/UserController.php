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
}