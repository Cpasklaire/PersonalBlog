<?php

namespace App\Lib;

class DatabaseConnection 
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO {

        if($this->database == null) 
        {
<<<<<<< Updated upstream
            $this->database = new \PDO('mysql:host=localhost;dbname=baseblog;charset=utf8', 'root', 'root');
=======
/*              $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();  */

            $this->database = new \PDO('mysql:host=localhost;dbname=blogphp;charset=utf8', 'root', 'root');
>>>>>>> Stashed changes
        }
        return $this->database;
    }
}