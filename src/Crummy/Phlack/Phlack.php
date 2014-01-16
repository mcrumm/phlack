<?php

namespace Crummy\Phlack;

class Phlack
{
    private $username;
    private $token;

    public function __construct($username, $token)
    {
        $this->username = $username;
        $this->token    = $token;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getToken()
    {
        return $this->token;
    }
}
