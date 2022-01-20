<?php

include_once("../Private/config/ConnectSingleton.php");
include_once("../Private/classes/Request.php");
include_once("../Private/classes/State/State.php");
include_once("../Private/classes/State/Requested.php");
include_once("../Private/classes/State/Accepted.php");
include_once("../Private/classes/State/Closed.php");
include_once("../Private/classes/User.php");
include_once("../Private/classes/student.php");

session_start();

$logged = false;
if (isset($_SESSION['obj'])) {
  $logged = true;
  $student = $_SESSION['obj'];
  $student_id = $student->getId();
  $name = $student->getUsername();
} else {
  $logged = false;
}

$connector = ConnectSingleton::getInstance();
$con = $connector->getConnection();

if (isset($_GET['remove'])) {
  $req_id = $_GET['remove'];

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

  $sql6 = "UPDATE notification SET availability=1 WHERE request_id='$req_id'";
  $result6 = mysqli_query($con, $sql6);

  echo '<script>alert("You removed this request! ")</script>';

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
    <title> My Requests </title>

    

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.1/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon.ico">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/logout.css">
<link rel="stylesheet" href="css/theme.css">
<link rel="stylesheet" href="css/ReqAcceptDecline.css">
<link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">
<meta name="theme-color" content="#7952b3">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
  </head>
  <body>
     <!-- navigation bar -->
     <div class="topnav">
            <a href="index.php">Home</a>
            <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if($student instanceof Student){?>href="dashboard.php"<?php }else{?>href="teacherDashboard.php"<?php }?>>Dashboard</a></div>
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


    <div class="table-wrapper">
    <?php
      $sql1 = "SELECT * FROM request WHERE student_id='$student_id' AND state='Requested'";
      $result1 = mysqli_query($con, $sql1);
    ?>
    <br> <br> <br>
    <table class="fl-table">
        <thead>
        <tr>
          <th> Course Name </th>
          <th> Teacher Name </th>
          <th> Action </th>
        </tr>
        </thead>
        <tbody>
        <?php
          while($row = $result1->fetch_assoc()): 
            // $req_id = $row['id'];
            $teacher_id = $row['teacher_id'];
            $class_id = $row['class_id'];

            $sql2 = "SELECT * FROM class WHERE Id='$class_id'";
            $result2 = mysqli_query($con, $sql2);

            while($row2 = $result2->fetch_assoc()):
              if($row2["grade"] == 'None'){
                $coursename = $row2["subject"];
              } else {
                $coursename = $row2["subject"]." - Grade ".$row2["grade"];
            } endwhile;

            $sql3 = "SELECT * FROM teacher WHERE Id='$teacher_id'";
            $result3 = mysqli_query($con, $sql3);

            while($row3 = $result3->fetch_assoc()):
              $fullname = $row3['designation']." ".$row3['first_name']." ".$row3['last_name'];
            endwhile;

          
          ?>
        <tr>
            <td> <?php echo $coursename ?> </td>
            <td> <?php echo $fullname ?> </td>
            <td>
            <a href="StudentRequests.php?remove=<?php echo $row['id']?>" class="declinebtn"> Remove </a>
            </td>  
        </tr>
        <?php endwhile; ?>
        <tbody>
    </table>
</div>

      
</body>
</html>