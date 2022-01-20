<?php

include_once("AdTemp.php");

function factoryMethod($id){
        $conn = mysqli_connect("localhost","root","","myscholar");
        $sql = "SELECT * FROM advertisement WHERE Id=$id";
        $sql = mysqli_query($conn,$sql);
        if(mysqli_query_run($sql)>0){
            $sql=mysqli_fetch_array($sql);
            $ad = new AdTemp($sql['teacher_id'],$sql['heading'],$sql['description']);
            $ad->setId($id);
            return $ad;
        }else{
            return NULL;
        }
}
?>