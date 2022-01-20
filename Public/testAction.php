<?php 
include_once("classes/connector.php");

//create connection
$connector = new Connector();
$conn = $connector->connectDatabase();
$grade="9";
$subject="Science";
$cls_qry = "SELECT * FROM class WHERE subject='$subject'AND grade='$grade'";
$cls_qry = mysqli_query($conn,$cls_qry);
if(mysqli_num_rows($cls_qry)>0){
    foreach($cls_qry as $cls){
        if($cls['grade']==9){
            echo "have";
        }
    }
}
else{
    echo "don't hv";
}
?>