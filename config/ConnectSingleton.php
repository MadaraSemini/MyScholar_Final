<?php

    class ConnectSingleton{
        private static ConnectSingleton $instance;
        private $host;
        private $user;
        private $password;
        private $db;
        private $connec;

        private function __construct()
        {
            $this->host="localhost";
            $this->user="root";
            $this->password="";
            $this->db="myscholar";
            $connection=mysqli_connect("localhost","root","","myscholar");
            $this->connec = $connection;
            if(!$connection){
                echo("connection error".mysqli_connect_error()."<br/>");
                die();
            }
            
        }
        public static function getInstance(): ConnectSingleton{
            if (!isset(self::$instance)) {
                self::$instance= new ConnectSingleton();
            }
            return self::$instance;
        }
        public function getConnection(){
            return $this->connec;
        }
    }


?>