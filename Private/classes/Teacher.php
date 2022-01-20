<?php

    include_once("User.php");

    class Teacher extends User{
        private $designation;
        private $description;
        private $contactNumber;
        private $ratingObjects;
        private $overallRating;

        private static $teacherObjects=array();

        private function __construct($firstName,$lastName,$username,$password,$email,$district,$designation, $description, $contactNumber)
        {
            parent::__construct($firstName,$lastName,$username,$password,$email,$district);
            $this->designation=$designation;
            $this->description=$description;
            $this->contactNumber=$contactNumber;
            $this->ratingObjects=array();
        }

        public static function getInstance($id,$firstName,$lastName,$username,$password,$email,$district,$designation, $description, $contactNumber){
            if(array_key_exists($id,self::$teacherObjects)){
                return self::$teacherObjects[$id];
            }
            else{
                $teacher=new static($firstName,$lastName,$username,$password,$email,$district,$designation, $description, $contactNumber);
                self::$teacherObjects[$id]=$teacher;
                return $teacher;
            }
        }

        public function setDesignation($designation){
            $this->designation=$designation;
        }

        public function setDescription($description){
            $this->description=$description;
        }

        public function setContactNumber($contactNumber){
            $this->contactNumber=$contactNumber;
        }

        public function getDesignation(){
            return $this->designation;
        }

        public function getDescription(){
            return $this->description;
        }

        public function getContactNumber(){
            return $this->contactNumber;
        }

        public function setOverallRating($overallRating){
            $this->overallRating=$overallRating;
        }

        public function getOverallRating(){
            return $this->overallRating;
        }

        public function addRatings($rating){
            array_push($this->ratingObjects,$rating);
        }

    }


?>