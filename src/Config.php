<?php

namespace App;

use Dotenv;

class Config {

    static private $isLoaded;     

    static public function getConfig($key = null) {
        if (!self::$isLoaded) {
            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();
            self::$isLoaded = true;
        }
        if (!$key) return $_ENV;
        return $_ENV[$key];
    }
}