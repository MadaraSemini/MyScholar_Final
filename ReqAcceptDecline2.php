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
  $teacher = $_SESSION['obj'];
  $teacher_id = $teacher->getId();
  $name = $teacher->getUsername();
} else {
  $logged = false;
}

$connector = new Connector();
$con = $connector->connectDatabase();

if (isset($_GET['decline'])) {
  $req_id = $_GET['decline'];

  $sql4 = "SELECT * FROM request WHERE id='$req_id'";
  $result4 = mysqli_query($con, $sql4);

  while ($row4 = mysqli_fetch_array($result4)) {
    $class_id = $row4['class_id'];
    $teacher_id = $row4['teacher_id'];
    $student_id = $row4['student_id'];
    $state = $row4['state'];
  }


  $reqObj = new Request($class_id, $student_id, $teacher_id);
  $reqObj->setId($req_id);

  $reqObj->close();
  $newState = $reqObj->getState();

  $sql5 = "UPDATE request SET state='$newState' WHERE id='$req_id'";
  $result5 = mysqli_query($con, $sql5);

  echo '<script>alert("You declined this request! ")</script>';

  // send notification
  $msg = "Request Declined";
  $date = date('y.m.d h:m:s');
  $sql_insert = mysqli_query($con, "INSERT INTO notification(message,cr_date,class_id,sender,receiver,request_id) VALUES('$msg','$date','$class_id','$teacher_id','$student_id','$req_id')");
  if ($sql_insert) {
    echo "<script>alert('message sent');</script>";
  } else {
    echo mysqli_error($con);
  }
}




if (isset($_GET['accept'])) {
  $req_id = $_GET['accept'];

  $sql4 = "SELECT * FROM request WHERE id='$req_id'";
  $result4 = mysqli_query($con, $sql4);

  while ($row4 = mysqli_fetch_array($result4)) {
    $class_id = $row4['class_id'];
    $teacher_id = $row4['teacher_id'];
    $student_id = $row4['student_id'];
    $state = $row4['state'];
  }

  $sql5 = "SELECT * FROM class WHERE Id='$class_id'";
  $result5 = mysqli_query($con, $sql5);

  while ($row5 = mysqli_fetch_array($result5)) {
    $current_capacity = $row5['current_capacity'];
    $capacity = $row5['capacity'];
  }

  if ($current_capacity < $capacity) {
    $reqObj = new Request($class_id, $student_id, $teacher_id);
    $reqObj->setId($req_id);

    $reqObj->proceedToNext();
    $newState = $reqObj->getState();

    $sql6 = "UPDATE request SET state='$newState' WHERE id='$req_id'";
    $result6 = mysqli_query($con, $sql6);

    $sql7 = "INSERT INTO student_class (class_id, student_id) VALUES ('$class_id', '$student_id')";
    $result7 = mysqli_query($con, $sql7);

    $current_capacity = $current_capacity + 1;

    $sql8 = "UPDATE class SET current_capacity='$current_capacity' WHERE Id='$class_id'";
    $result8 = mysqli_query($con, $sql8);


    // send notification
    $msg = "Request Accepted";
    $date = date('y.m.d h:m:s');
    $sql_insert = mysqli_query($con, "INSERT INTO notification(message,cr_date,class_id,sender,receiver,request_id) VALUES('$msg','$date','$class_id','$teacher_id','$student_id','$req_id')");
    if ($sql_insert) {
      echo "<script>alert('message sent');</script>";
    } else {
      echo mysqli_error($con);
    }

    echo '<script>alert("You accepted this request! ")</script>';
  } else {
    /*
    $reqObj = new Request($class_id, $student_id, $teacher_id );
    $reqObj->setId($req_id);

    $reqObj->close();
    $newState = $reqObj->getState();

    $sql6 = "UPDATE request SET state='$newState' WHERE id='$req_id'";
    $result6 = mysqli_query($con,$sql6);
    */

    echo '<script>alert("Sorry! You cannot accept this request. Your class is full!")</script>';
  }
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
  <link rel="stylesheet" href="theme.css">

  
  <title> Class Requests </title>


</head>

<body>
  <!-- navigation bar -->
  <div class="topnav">
    <a href="index.php">Home</a>
    <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if ($teacher instanceof Student) { ?>href="dashboard.php" <?php } else { ?>href="teacherDashboard.php" <?php } ?>>Dashboard</a></div>
    <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id3 style="float: right;" onclick="document.getElementById('id01').style.display='block'">Log out</a></div>




    <div id="id01" class="logout">
      <div class="logout_msg animate">
        <div class="top">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        </div>
        <h1>Log Out</h1>
        <p><?php echo $name ?> are you sure you want to log out?</p>
        <form action="classCard.php" method="post">
          <button id="log" type="submit" class="yes" name="logout">Yes</button>
          <button id="log" type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">No</button>
        </form>


      </div>
    </div>

    <a style="float:right" id=id2 href="contactUs.php">Contact us</a>
  </div>

  <div class="table-wrapper">
    <?php
      $sql1 = "SELECT * FROM request WHERE teacher_id='$teacher_id' AND state='Requested'";
      $result1 = mysqli_query($con, $sql1);
    ?>
    <table class="fl-table">
        <thead>
        <tr>
            <th> Student name </th>
            <th> Course name </th>
            <th colspan="2" >Action</th>
            
        </tr>
        </thead>
        <tbody>
        <?php
          while ($row = $result1->fetch_assoc()) :
            // $req_id = $row['id'];
            $student_id = $row['student_id'];
            $class_id = $row['class_id'];

            $sql2 = "SELECT * FROM class WHERE Id='$class_id'";
            $result2 = mysqli_query($con, $sql2);

            while ($row2 = $result2->fetch_assoc()) :
              if ($row2["grade"] == 'None') {
                $coursename = $row2["subject"];
              } else {
                $coursename = $row2["subject"] . " - Grade " . $row2["grade"];
              }
            endwhile;

            $sql3 = "SELECT * FROM student WHERE id='$student_id'";
            $result3 = mysqli_query($con, $sql3);

            while ($row3 = $result3->fetch_assoc()) :
              $fullname = $row3['First_name'] . " " . $row3['Last_name'];
            endwhile;
        ?>
        <tr>
            <td> <?php echo $fullname ?> </td>
            <td> <?php echo $coursename ?> </td>
            <td>
                <a href="ReqAcceptDecline2.php?accept=<?php echo $row['id'] ?>" class="acceptbtn"> Accept </a>
                <a href="ReqAcceptDecline2.php?decline=<?php echo $row['id'] ?>" class="declinebtn"> Decline </a>
            </td>  
        </tr>
        <?php endwhile; ?>
        <tbody>
    </table>
</div>


</body>

</html>