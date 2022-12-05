<?php


namespace Models\Worker;

use Exceptions\UncorrectAgeException;
use Models\User\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/Models/User/User.php';


class Worker extends User
{

    private $salary;

    public function getSalary()
    {
        return $this->salary;
    }

    public function setSalary($salary): void
    {
        $this->salary = $salary;
    }

    public function hello() : void
    {
        echo 'Привет! Я - ' . $this->getName() . '. Мне ' .$this ->getAge(). ' лет, моя зарплата на сегодня ' .$this ->getSalary() .' рублей';
    }

}