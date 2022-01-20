<?php

include_once("FactoryDP/Product.php");

class Request implements Product{
    private State $state;
    private $id;
    private $classId;
    private $studentId;
    private $teacherId;

    public function __construct($classId,$studentId,$teacherId)
    {
        $this->state= Requested::getInstance();
        $this->classId = $classId;
        $this->studentId = $studentId;
        $this->teacherId = $teacherId;
    }
    //setters
    public function setState(State $state)
    {
        $this->state = $state;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    //getters
    public function getState()
    {
        return $this->toString();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getClassId()
    {
        return $this->classId;
    }
    public function getStudentId()
    {
        return $this->studentId;
    }
    public function getTeacherId()
    {
        return $this->teacherId;
    }
    //Go to the next state
    public function proceedToNext()
    {
        $this->state->proceedToNext($this);
    }

    //Return the state as a String
    public function toString()
    {
        return $this->state->toString();
    }

    //Teacher can deline a request and student can cancel a request
    //In both cases the request will be closed
    public function close()
    {
        $this->state=Closed::getInstance();
    }
}

?>