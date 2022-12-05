<?php


namespace Models\Driver\Driver;

use \Models\Worker\Worker;


class Driver extends Worker
{
    private $stazh;
    private array $category;


    public function getStazh()
    {
        return $this->stazh;
    }


    public function getCategory() : array
    {
        return $this->category;
    }


    public function setStazh($stazh): void
    {
        $this->stazh = $stazh;
    }


    public function setCategory(array $category): void
    {
        $this->category = $category;
    }


}