<?php


namespace Models\User;

use Exceptions\UncorrectAgeException;

class User
{
    protected $name;
    protected $age;

    public function __construct(string $name, int $age)
    {
        if ($this -> checkAge ($age)) {
            $this -> setName ($name) -> setAge ($age);
        }
    }


    public function getName()
    {
        return $this -> name;
    }


    public function getAge()
    {
        return $this -> age;
    }


    public function setName ($name) : object
    {
        $this -> name = $name;
        return $this;
    }


    public function setAge ($age) : object
    {
        if ($this -> checkAge($age)) {
            $this -> age = $age;
            return $this;
        }
        else {
            throw new UncorrectAgeException('Укажите возраст от 18 от 100!');
        }
    }

    private function checkAge($age) : bool
    {
        if ($age > 18 && $age < 101)
        {
            return true;
        }
        else {
            return false;
        }
    }


}