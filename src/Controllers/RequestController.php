<?php

namespace App\Controllers;

class RequestController
{
    public ?array $server = null;
    public ?array $get = null;
    public ?array $post = null;
    public ?array $session = null;

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;
        $this->session = $_SESSION;
    }
}