<?php
    class Ad{
        private $id;
        private $teacher_id;
        private $heading;
        private $description;
        private $file;
        private $classList;

        public function __construct($teacher_id,$heading,$description){
            $this->teacher_id = $teacher_id;
            $this->heading = $heading;
            $this->description = $description;
            $this->classList = array();
        }
        //setters
        public function setId($id){
            $this->id=$id;
        }
        public function setHeading($heading){
            $this->heading=$heading;
        }
        public function setDescription($description){
            $this->description=$description;
        }
        public function setFile($file){
            $this->file=$file;
        }
        //getters
        public function getId(){
            return $this->id;
        }
        public function getHeading(){
            return $this->heading;
        }
        public function getDescription(){
            return $this->description;
        }
        public function getFile(){
            return $this->file;
        }
        public function getTeacherId(){
            return $this->teacher_id;
        }
        public function getClassArray(){
            return $this->classList;
        }
    }
?>