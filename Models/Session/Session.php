<?php


namespace Models\Session;


class Session
{
    public function __construct () {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /** метод установки переменной сессии */
    public function set ($name, $value): void {
        $_SESSION[$name] = $value;
    }

    /** метод возврата переменной сессии */
    public function get ($name) {
        return $_SESSION[$name];
    }

    /** метод удаления переменной сессии */
    public function delete ($name): void {
        unset ($_SESSION[$name]);
    }

    /** метод проверки наличия переменной сессии */
    public function check ($name): bool {
        return isset($_SESSION[$name]);
    }


}