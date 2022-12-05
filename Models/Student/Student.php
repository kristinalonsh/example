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


    public function setCourse($course): void
    {
        $this->course = $course;
    }


    public function setStipendia($stipendia): void
    {
        $this->stipendia = $stipendia;
    }

}