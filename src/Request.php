<?php

namespace App;

class Request
{
    public ?array $server = null;
    public ?array $get = null;
    public ?array $post = null;
    public ?array $session = null; // should be private

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;
        $this->session = $_SESSION; // read about references in PHP with &$_SESSION ... 
    }

    public function setSession($sessionKey, $sessionValue) {
        $_SESSION[$sessionKey] = $sessionValue;
    }

    public function redirect($location) {
        return header('Location: ' . $location);
    }
}