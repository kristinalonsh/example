<?php


namespace Models\Cookie;


class Cookie
{
    protected $name_cookie;
    protected $value_cookie;

    public function __construct()
    {

    }


    public function setCookie($name_cookie, $value_cookie): object
    {
        setCookie($name_cookie, $value_cookie);
        return $this;
    }


    public function getCookie($name_cookie)
    {
        return $_COOKIE [$name_cookie];
    }

    public function del (string $name_cookie) : void
    {
        if (isset($_COOKIE [$name_cookie])) {
            setcookie ($name_cookie , "", time() +1);
        }
    }

}