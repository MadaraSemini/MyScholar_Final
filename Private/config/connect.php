<?php

$host="Localhost";
$use="root";
$password="";
$db="myscholar";

$con=mysqli_connect($host,$use,$password,$db);
// mysqli_select_db($con,$db);
if(!$con){
    echo("connection error".mysqli_connect_error()."<br/>");
    die();
}
?>