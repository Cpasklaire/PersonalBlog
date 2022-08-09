<?php

namespace App\Models;

use \Ramsey\Uuid\Uuid;

class User {
    public string $id;
    public string $pseudo;
    public string $admin;
}

class UserModel extends BaseModel{

    //login

    public function login(string $email, string $password): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM users WHERE email = '$email'"
        );

        $user = $statement->fetch();
        $userInfo = [];

        if($user) {
            if(password_verify($password ,$user['mdp'])) {
                    $userInfo[] = $user['id'];
                    $userInfo[] = $user['pseudo'];
                    $userInfo[] = $user['admin'];
            } 
        }

        return $userInfo;
    }

    /*create a user*/
    public function createUser(string $pseudo, string $email, string $password): bool {

        $v4 = Uuid::uuid4();
        $newId = $v4->toString();
        $newPassword = password_hash($password, PASSWORD_DEFAULT);

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO users(id, email, pseudo, mdp, createdAt) VALUES (?, ?, ?, ?, ?, NOW())"
        );

        $affectedLine = $statement->execute([$newId, $email, $pseudo, $newPassword]);

        return ($affectedLine > 0);
        
    }

    /*send email
    public function sendMail(string $pseudo, string $email, string $message) {

        $contact = "clea.leroux@hotmail.fr";
        $object = $pseudo;
        $entetes="From: " . $email;
        $entetes.="Content-Type: text/html; charset=iso-8859-1";

        if(email(
            $contact,
            $object,
            $message
        )) {
            echo 'email send';
        } else {

            echo 'email not send';
        }

    }*/

}