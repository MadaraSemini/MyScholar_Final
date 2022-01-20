<?php
    abstract class User{
        private $id;
        private $firstName;
        private $lastName;
        private $username;
        private $password;
        private $email;
        private $district;
        private $profilePhoto;
        private $fullName;
        private $logged;

        public function __construct($firstName,$lastName,$username,$password,$email,$district)
        {
            //$this->id=$id;
            $this->firstName=$firstName;
            $this->lastName=$lastName;
            $this->username=$username;
            $this->password=$password;
            $this->email=$email;
            $this->district=$district;
        }

        public function setId($id){
            $this->id=$id;
        }

        public function setProfPhoto($profilePhoto){
            $this->profilePhoto=$profilePhoto;
        }

        public function setFirstName($firstName){
            $this->firstName=$firstName;
        }

        public function setLastName($lastName){
            $this->lastName=$lastName;
        }

        public function setUsername($username){
            $this->username=$username;
        }

        public function setEmail($email){
            $this->email=$email;
        }

        public function setPassword($password){
            $this->password=$password;
        }

        public function setDistrict($district){
            $this->district=$district;
        }

        public function getId(){
            return $this->id;
        }

        public function getFirstName(){
            return $this->firstName;
        }

        public function getLastName(){
            return $this->lastName;
        }

        public function getUsername(){
            return $this->username;
        }

        public function getPassword(){
            return $this->password;
        }

        public function getEmail(){
            return $this->email;
        }

       
        public function getDistrict(){
            return $this->district;
        }

        public function getProfPhoto(){
            return $this->profilePhoto;
        }

        public function setFullName(){
            $this->fullName=$this->firstName." ".$this->lastName;
        }

        public function getFullName(){
            return $this->fullName;
        }

        public function login(){
            $this->logged=true;
        }

        public function logout(){
            $this->logged=false;
        }
    }


?>