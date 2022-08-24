<?php

namespace App\Models;

class User {
    public string $id;
    public string $pseudo;
    public string $admin;
}

class UserModel extends BaseModel{

    //login

    public function login(string $pseudo): object {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM users WHERE pseudo = '$pseudo' LIMIT 1"
        );
        return $statement->fetchObject();   
        
    }

    public function getUser($id) {
        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM Users WHERE id = $id"
        );
        return $statement->fetchObject();   
    }

    /*create a user*/
    public function createUser(string $pseudo, string $email, string $password): bool {

        $mdp = password_hash($password, PASSWORD_DEFAULT);

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO users(email, pseudo, mdp, createdAt) VALUES (?, ?, ?, NOW())"
        );

        $affectedLine = $statement->execute([$email, $pseudo, $mdp]);

        return ($affectedLine > 0);
        
    }

    public function getUsers(): array {
        
        $statement = $this->connection->getConnection()->query(
            " SELECT * FROM Users ORDER BY updatedAt DESC"
        );
    
        $posts = [];
    
        while($row = $statement->fetch()) 
        {
            $user = new User();
            $user->userId = $row['id'];
            $user->pseudo = $row['pseudo'];
            $user->email = $row['email'];
            $user->admin = $row['admin'];
            $user->createdAt = $row['createdAt'];
    
            $users[] = $user;
        }
        return $users;
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