<?php

class RealClassPage extends ClassPage{

    private $anouncements;
    private $coursenotes;
    private static $realClassObjects = array();

    public function __construct($subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $currentCapacity){
        parent::__construct($subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $currentCapacity);
        $this->anouncements = array();
        $this->coursenotes = array();
    }


    public static function getInstance($id, $subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $currentCapacity){
        
        if(array_key_exists($id, self::$realClassObjects)){
            return self::$realClassObjects[$id];
        }
        else {
            $realClass = new static($subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $currentCapacity);
            self::$realClassObjects[$id] = $realClass;
            return $realClass;
        }
    }


    public function setAnouncements(){
        $this->anouncements = array();
    }

    public function setCoursenotes(){
        $this->coursenotes = array();
    }


    public function getAnouncements(){
        return $this->anouncements;
    }

    public function getCoursenotes(){
        return $this->coursenotes;
    }


    public function addAnouncements($anouncement){
        array_push($this->anouncements, $anouncement);
    }

    public function addCourseNotes($coursenote){
        array_push($this->coursenotes, $coursenote);
    }



}

?>