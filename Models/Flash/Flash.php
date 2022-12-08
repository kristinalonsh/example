<?php


namespace Models\Flash;

use Models\Session\Session;


class Flash
{
    private $saveSession;

    public function __construct()
    {
        $this -> saveSession = new Session();
    }

    public function setMessage ($name, $value) : object
    {
        $this -> saveSession -> set ($name, $value);
        return $this;
    }

    public function getMessage ($name) : string
    {
        if (!$this -> saveSession -> check ($name)) {
            return '';
        }
        return $this -> saveSession -> get ($name);
    }

}