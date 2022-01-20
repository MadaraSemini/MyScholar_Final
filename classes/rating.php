<?php
    include_once("FactoryDP/Product.php");
    class Rating implements Product{
        
        private $teacherID;
        private $ratingValue;
        public function __construct($teacherID)
        {
            $this->teacherID=$teacherID;
            
        }

        public function setRating($ratingValue){
            $this->ratingValue=$ratingValue;
            
        }

        public function getRating(){
            return $this->ratingValue;
        }

        public function getTeacherID(){
            return $this->teacherID;
        }
    }


?>

