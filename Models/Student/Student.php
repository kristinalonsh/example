<?php


namespace Models\Student;

use Models\User\User;


class Student extends User
{
    private $stipendia;
    private $course;


    public function getCourse()
    {
        return $this->course;
    }


    public function getStipendia()
    {
        return $this->stipendia;
    }


    public function setCourse($course): object
    {
        $this->course = $course;
        return $this;
    }


    public function setStipendia($stipendia): object
    {
        $this->stipendia = $stipendia;
        return $this;
    }

}