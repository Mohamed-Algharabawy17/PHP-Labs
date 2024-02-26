<?php

class Counter
{
    private $visitCountFile = visit_count_file;
    private $vivsit;

    public function __construct($visitCountFile)
    {
        $this -> visitCountFile = $visitCountFile;
    }

    public function check()
    {
        session_start();
        if ($_SESSION[$this -> vivsit] == false)
        {
            $this->increment();
            $_SESSION[$this -> vivsit] = true;
        } 
        $data = $this->getCount();
        return $data;
    }

    public function getCount()
    {
        return file_exists($this -> visitCountFile) ? (int) file_get_contents($this -> visitCountFile) : 0;
    }

    public function increment()
    {
        $count = $this -> getCount();
        $count++;
        file_put_contents($this -> visitCountFile, $count);
    }
}
