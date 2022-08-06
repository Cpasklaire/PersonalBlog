<?php

namespace App\Models;

use App\Lib\DatabaseConnection;
use \Ramsey\Uuid\Uuid;

class UserModel {

    public DatabaseConnection $connection;

    /*log user*/
    public function login(string $email, string $password): array {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM user WHERE email = '$email'"
        );

        $user = $statement->fetch();
        $userInfo = [];

        if($user) {
            if(password_verify($password ,$user['pwd'])) {
                    $userInfo[] = $user['id'];
                    $userInfo[] = $user['pseudo'];
            } 
        }

        return $userInfo;
        
    }

    /*log admin*/
    public function adminLogin(string $email, string $password): bool {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM user WHERE email = '$email'"
        );

        $user = $statement->fetch();

        if($user) {
            if(password_verify($password ,$user['pwd'])) {
                if($user['admin']) {
                    return true;
                }
            } 
        }

        return false;
        
    }

    /*create a user*/
    public function createUser(string $pseudo, string $email, string $password): bool {

        $v4 = Uuid::uuid4();
        $newId = $v4->toString();
        $newPassword = password_hash($password, PASSWORD_DEFAULT);

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO user(id, email, pseudo, mdp, createdAt) VALUES (?, ?, ?, ?, ?, NOW())"
        );

        $affectedLine = $statement->execute([$newId, $email, $pseudo, $newPassword]);

        return ($affectedLine > 0);
        
    }

    /*send email*/
    public function sendMail(string $pseudo, string $email, string $message) {

        $contact = "monmail@gmail.com";
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

    }

}