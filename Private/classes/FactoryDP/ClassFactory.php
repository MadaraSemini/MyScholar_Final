<?php
include_once("../../config/ConnectSingleton.php");
include_once("Factory.php");
include_once("Class.php");
include_once("Product.php");

class ClassFactory extends Factory{

    public function factoryMethod($username,$password): Product{
        return new Product();
    }
    public function factoryMethod3($username,$password): Product{
        return new Product();
    }

    public function factoryMethod2($id): Product{
        $connector = ConnectSingleton::getInstance();
        $conn = $connector->getConnection();

        $query1 = "SELECT * FROM class WHERE Id='$id'";
        $query_run1 = mysqli_query($conn, $query1);

        $sql = "SELECT * FROM anouncement WHERE class_id='$id'";
        $result = mysqli_query($conn, $sql);
        $anouncements = array();

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $anouncements[] = $row;
            }
        }

        $sql2 = "SELECT * FROM coursenote WHERE class_id='$id'";
        $result2 = mysqli_query($conn, $sql2);
        $coursenotes = array();

        if(mysqli_num_rows($result2) > 0){
            while($row2 = mysqli_fetch_assoc($result2)){
                $coursenotes[] = $row2;
            }
        }

        while($row = mysqli_fetch_array($query_run1)){
            $id = $row["Id"];
            $teacher_id = $row["teacher_id"];
            $grade = $row["grade"];
            $subject = $row["subject"];
            $medium = $row["medium"];
            $location = $row["location"];
            $day = $row["day"];
            $starttime = $row["starttime"];
            $endtime = $row["endtime"];
            $classtype = $row["classtype"];
            $fee = $row["fee"];
            $capacity = $row["capacity"];
            $current_capacity = $row["current_capacity"];

            $class = new ClassPage1($id, $teacher_id, $subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $current_capacity);         
            $class->setAnouncements($anouncements);
            $class->setCoursenotes($coursenotes);

            return $class;
        }
    }


}

?>