<?php

    include_once("../Private/config/ConnectSingleton.php");
    include_once("../Private/classes/User.php");
    include_once("../Private/classes/Teacher.php");
    session_start();
    $teacher = $_SESSION['obj'];
    $teacher_id = $teacher->getId();

    $connector = ConnectSingleton::getInstance();
    $conn = $connector->getConnection();

    if($conn->connect_error) {
        die("Connection Failed: " .$conn->connect_error);
    }
    if(isset($_POST['submit'])){   //add exceptions
        $heading = $_POST["heading"];
        $description = $_POST["description"];
        $classlist = $_POST['classlist'];

        $heading=mysqli_real_escape_string($conn,"$heading");
        $description=mysqli_real_escape_string($conn,"$description");


        if($_POST['submit']=="Submit"){

            $background = rand(1,10);
            $background.= ".jpg";

            $sql = "INSERT INTO advertisement (teacher_id,heading,description,background) VALUES ('$teacher_id','$heading','$description','$background')";
            $result1 = mysqli_query($conn,$sql);
            $ad_id = $conn->insert_id;
            
            foreach($classlist as $class){
                $sql2 = "INSERT INTO advertisement_class (ad_id,class_id) VALUES ('$ad_id','$class')";
                $result2 = mysqli_query($conn,$sql2);
            }

            
        }
        else{
            $ad_id = $_POST['adid'];
            $sql = "UPDATE advertisement 
                    SET 
                        heading = '$heading',
                        description = '$description'
                    WHERE
                        Id = $ad_id";
            $result1=mysqli_query($conn,$sql);
            $sql = "DELETE FROM advertisement_class WHERE ad_id = $ad_id";
            $result2=mysqli_query($conn,$sql);
            foreach($classlist as $class){
                $sql2 = "INSERT INTO advertisement_class (ad_id,class_id) VALUES ('$ad_id','$class')";
                $result2 = mysqli_query($conn,$sql2);
            }
        }
        
        if ($result2 === TRUE and $result1 === TRUE) {//session
            echo "New record created";
            header("Location: adCollectionWithFactory.php");
        }else {
            echo "Error: " . $result1 . "<br>" . $conn->error;
        }
    }
    $conn->close();
?>