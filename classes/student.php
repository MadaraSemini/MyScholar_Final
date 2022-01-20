<?php

//use Student as GlobalStudent;

class Student extends User{
        private $grade;

        /*Multiton pattern implimentation line 6-20*/
        private static $instances = array();

        public static function getInstance($id,$firstName,$lastName,$username,$password,$email,$district)
        {
            if(!array_key_exists($id, self::$instances)) {
                self::$instances[$id] = new self($firstName,$lastName,$username,$password,$email,$district);
            }
    
            return self::$instances[$id];
        }
    
    
        // prevent the instance from being cloned
        private function __clone(){}


        private function __construct($firstName,$lastName,$username,$password,$email,$district)
        {
            parent::__construct($firstName,$lastName,$username,$password,$email,$district);
            //$this->grade=$grade;
        }

        public function setGrade($grade){
            $this->grade=$grade;
        }

        public function getGrade(){
            return $this->grade;
        }

    }
 

?>