<?php

include_once("classes/connector.php");
include_once("classes/Request.php");
include_once("classes/State/State.php");
include_once("classes/State/Requested.php");
include_once("classes/State/Accepted.php");
include_once("classes/State/Closed.php");
include_once("classes/User.php");
include_once("classes/Teacher.php");

session_start();

$logged = false;
if (isset($_SESSION['obj'])) {
$logged = true;
$user = $_SESSION['obj'];

$name = $user->getUsername();
} else {
    $logged = false;
}

$teacher = $_SESSION['teacher'];
$class_id = $_GET['id'];

$teacher_id = $teacher->getId();

$connector = new Connector();
$con = $connector->connectDatabase();



if(isset($_GET['remove'])){
    $student_class_id = $_GET['remove'];

    $sql5 = "SELECT * FROM student_class WHERE id='$student_class_id'";
    $result5 = mysqli_query($con, $sql5);

    while($row5 = $result5->fetch_assoc()):
      $cls_id = $row5['class_id'];
      $std_id=$row5['student_id'];
    endwhile;
  
    $sql6 = "DELETE FROM student_class WHERE id='$student_class_id'";
  
    echo '<script>alert("You removed this student! ")</script>';

    if (mysqli_query($con, $sql6)){

      $sql7 = "SELECT * from class WHERE Id='$cls_id'";
      $result7 = mysqli_query($con, $sql7);

      while($row7 = $result7->fetch_assoc()):
        $current_capacity = $row7['current_capacity'];
      endwhile;

      $newCurrCapacity = $current_capacity - 1;                  
      echo $newCurrCapacity;

      $sql8 = "UPDATE class SET current_capacity='$newCurrCapacity' WHERE Id='$cls_id'";
      $result8 = mysqli_query($con, $sql8);

    }

      // send notification
    $msg = $teacher->getUsername()." unenrolled you.";
    $date = date('y.m.d h:m:s');
    $sql_insert = mysqli_query($con, "INSERT INTO notification(message,cr_date,class_id,sender,receiver) VALUES('$msg','$date','$cls_id','$teacher_id','$std_id')");
    if ($sql_insert) {
      echo "<script>alert('message sent');</script>";
    } else {
      echo mysqli_error($con);
    }

    $_SESSION['obj'] = $teacher;
    $url = "ViewStudentList2.php?id=".$cls_id;
    header('Location: '.$url);
  
  
}



?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="logout.css">
    <link rel="stylesheet" href="ReqAcceptDecline.css">
    <link rel="icon" type="image/x-icon" href="Images/icon.png">
    <title> Student List </title>

  </head>
  <body>
     <!-- navigation bar -->
 <div class="topnav">
        <a href="index.php">Home</a>
        <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if($user instanceof Student){?>href="dashboard.php"<?php }else{?>href="teacherDashboard.php"<?php }?>>Dashboard</a></div>
            <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id3 style="float: right;" onclick="document.getElementById('id01').style.display='block'">Log out</a></div>




            <div id="id01" class="logout">
                <div class="logout_msg animate">
                    <div class="top">
                        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    <h1>Log Out</h1>
                    <p><?php echo $name ?> are you sure you want to log out?</p>
                    <!-- <p>Are you sure you want to Log out?</p> -->
                    <!-- <input type="button" class="yes" name="logout"  value="Yes"> -->
                    <form action="classCard.php" method="post">
                        <button id="log" type="submit" class="yes" name="logout">Yes</button>
                        <button id="log" type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">No</button>
                    </form>


                </div>
            </div>
        <a style="float:right" id=id2 href="contactUs.php">Contact us</a>
    </div> 
    <h2> Student List </h2>
    <div class="table-wrapper">
    <?php
      $sql1 = "SELECT * FROM student_class WHERE class_id='$class_id'";
      $result1 = mysqli_query($con, $sql1);
    ?>
    <table class="fl-table">
        <thead>
        <tr>
            <th> Student name </th>
            <th> Action </th> 
        </tr>
        </thead>
        <tbody>
        <?php
          while($row = $result1->fetch_assoc()):
            $student_class_id = $row['id'];
            $student_id = $row['student_id'];

            $sql3 = "SELECT * FROM student WHERE id='$student_id'";
            $result3 = mysqli_query($con, $sql3);

            while($row3 = $result3->fetch_assoc()):
              $fullname = $row3['First_name']." ".$row3['Last_name'];
            endwhile;
        ?>
        <tr>
            <td> <?php echo $fullname ?> </td>
            <td>
                <a href="ViewStudentList2.php?remove=<?php echo $student_class_id?>" class="declinebtn"> Remove </a>
            </td>
        </tr>
        <?php endwhile; ?>
        <tbody>
    </table>
</div>

<a style = "position:relative; left:80px;" href="ClassPageForTeacher.php?id=<?php echo $class_id?>" class="acceptbtn"> Back to class </a>
    
</body>
</html>