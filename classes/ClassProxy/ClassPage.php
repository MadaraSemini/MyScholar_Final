<?php
interface ClassPage{
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