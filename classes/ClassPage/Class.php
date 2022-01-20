<?php

abstract class ClassPage{

    private $id;
    private $subject;
    private $day;
    private $starttime;
    private $endtime;
    private $fee;
    private $classtype;
    private $grade;
    private $medium;
    private $capacity;
    private $location;
    private $currentCapacity;

    public function __construct($subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $currentCapacity){
        $this->subject = $subject;
        $this->day = $day;
        $this->starttime = $starttime;
        $this->endtime = $endtime;
        $this->fee = $fee;
        $this->classtype = $classtype;
        $this->grade = $grade;
        $this->medium = $medium;
        $this->capacity = $capacity;
        $this->location = $location;
        $this->currentCapacity = $currentCapacity;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setSubject($subject){
        $this->subject = $subject;
    }

    public function setDay($day){
        $this->day = $day;
    }

    public function setStarttime($starttime){
        $this->starttime = $starttime;
    }

    public function setEndtime($endtime){
        $this->endtime = $endtime;
    }

    public function setFee($fee){
        $this->fee = $fee;
    }

    public function setClasstype($classtype){
        $this->classtype = $classtype;
    }

    public function setMedium($medium){
        $this->medium = $medium;
    }

    public function setGrade($grade){
        $this->grade = $grade;
    }

    public function setCapacity($capacity){
        $this->capacity = $capacity;
    }

    public function setCurrentCapacity($currentCapacity){
        $this->currentCapacity = $currentCapacity;
    }

    public function setLocation($location){
        $this->location = $location;
    }



    public function getId(){
        return $this->id;
    }

    public function getSubject(){
        return $this->subject;
    }

    public function getDay(){
        return $this->day;
    }

    public function getStarttime(){
        return $this->starttime;
    }

    public function getEndtime(){
        return $this->endtime;
    }

    public function getFee(){
        return $this->fee;
    }

    public function getClasstype(){
        return $this->classtype;
    }

    public function getMedium(){
        return $this->medium;
    }

    public function getGrade(){
        return $this->grade;
    }

    public function getCapacity(){
        return $this->capacity;
    }

    public function getCurrentCapacity(){
        return $this->currentCapacity;
    }

    public function getLocation(){
        return $this->location;
    }


    
}

?>