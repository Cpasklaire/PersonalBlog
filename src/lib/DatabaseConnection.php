<?php

namespace App\Lib;

use Dotenv;

class DatabaseConnection 
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO {

        if($this->database == null) 
        {
/*              $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();  */

            $this->database = new \PDO('mysql:host=localhost;dbname=blogphp;charset=utf8', 'root', 'root');
        }
        return $this->database;
    }
}

