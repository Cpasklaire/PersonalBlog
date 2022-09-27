<?php

namespace App\Lib;

class DatabaseConnection 
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO {

        if($this->database == null) 
        {
            $config = \App\Config::getConfig();

            $DB_NAME = $config['DB_NAME'];
            $DB_HOST = $config['DB_HOST'];
            $DB_USER = $config['DB_USER'];
            $DB_PASSWORD = $config['DB_PASSWORD'];
            
            $this->database = new \PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8", $DB_USER, $DB_PASSWORD);
        }
        return $this->database;
    }
}