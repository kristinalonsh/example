<?php


namespace Models\Cookie;


class Cookie
{
    protected $name_cookie;
    protected $value_cookie;

    public function __construct()
    {

    }


    public function setCookie($name_cookie, $value_cookie): void
    {
        setCookie($name_cookie, $value_cookie);
    }


    public function getCookie($name_cookie)
    {
        return $_COOKIE [$name_cookie];
    }

}