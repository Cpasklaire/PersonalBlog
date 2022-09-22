<?php

namespace App\Lib;

class DatabaseConnection 
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO {

        if($this->database == null) 
        {
            $config = \App\Config::getConfig();
            $this->database = new \PDO('mysql:host=localhost;dbname=blogphp;charset=utf8', $config['DB_USER'], $config['DB_PASSWORD']);
        }
        return $this->database;
    }
}