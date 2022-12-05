<?php


namespace Models\User;

use Exceptions\UncorrectAgeException;

class User
{
    protected $name;
    protected $age;

    public function __construct(string $name, int $age)
    {
        if ($this->checkAge($age)) {
            $this -> name = $name;
            $this -> age = $age;
        }
        else {
            throw new UncorrectAgeException('Пользователь не может быть младше 18 или старше 100 лет!');
        }

    }

    public function getName()
    {
        return $this->name;
    }


    public function getAge()
    {
        return $this->age;
    }


    public function setName($name): void
    {
        $this->name = $name;
    }


    public function setAge($age): void
    {
        if ($this->checkAge($age)) {
            $this->age = $age;
        }
        else {
            throw new UncorrectAgeException('Укажите возраст от 18 от 100!');
        }
    }

    private function checkAge($age) : bool
    {
        if ($age>18 & $age<101)
        {
            return true;
        }
        else {
            return false;
        }
    }


}