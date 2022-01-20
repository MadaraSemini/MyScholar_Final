<?php

    class Connector{
        public function connectDatabase(){
            $connec=mysqli_connect("localhost","root","","myscholar");
            if(!$connec){
                echo("connection error".mysqli_connect_error()."<br/>");
                die();
                return null;
            }else{
                return $connec;
            }
            
        }
    }


?>