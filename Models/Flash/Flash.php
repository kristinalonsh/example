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

    public function setMessage ($name, $value) : void {
        $this -> saveSession -> set ($name, $value);
    }

    public function getMessage ($name) {
        if($this->saveSession->check ($name)) {
            return $this->saveSession->get($name);
        }
    }

}