<?php

include_once("../Private/classes/User.php");
include_once("../Private/classes/Teacher.php");
include_once("../Private/config/ConnectSingleton.php");


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

if(isset($_GET["yes"])){

    $cls_id = $_GET['yes'];
    
    $connector = ConnectSingleton::getInstance();
    $con = $connector->getConnection(); 

    $sql2 = "DELETE FROM student_class WHERE class_id='$cls_id'";
    $result2 = mysqli_query($con, $sql2);

    $sql3 = "DELETE FROM request WHERE class_id='$cls_id'";
    $result3 = mysqli_query($con, $sql3);

    $sql4 = "DELETE FROM coursenote WHERE class_id='$cls_id'";
    $result4 = mysqli_query($con, $sql4);

    $sql5 = "DELETE FROM anouncement WHERE class_id='$cls_id'";
    $result5 = mysqli_query($con, $sql5);

    $sql6 = "DELETE FROM advertisement_class WHERE class_id='$cls_id'";
    $result6 = mysqli_query($con, $sql6);

    $sql = "DELETE FROM class WHERE Id='$cls_id'";

    if($con->query($sql) === TRUE){
        $_SESSION['obj'] = $teacher;
        $url = "teacherDashboard.php";
        header('Location: '.$url); 
    
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}



if(isset($_GET["no"])){
    $cls_id = $_GET['no'];
    $_SESSION['obj'] = $teacher;
    $url = "ClassPageForTeacher.php?id=".$cls_id;
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
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/logout.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">
    <title> Delete Class </title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/album/">

    

    <!-- Bootstrap core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.1/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/docs/5.1/assets/img/favicons/favicon.ico">
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

      .bg-img{
        background-image: url("Images/unenroll2.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        height: 603px;
        }

        main{
            background-color: #95BCCB;
        }

    </style>

    
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

<main>
  <section class="py-5 text-center container">
  <div class="bg-img">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <br> <br> <br> <br> <br> 
        <h1 class="fw-light"> <b> Delete class </b> </h1>
        <p class="lead text-muted"> <b> Are you sure you want to delete this class page? </b> </p>
        <p>
          <a href="DeleteClass.php?yes=<?php echo $class_id?>" class="btn btn-primary my-2"> Yes </a>
          <a href="DeleteClass.php?no=<?php echo $class_id?>" class="btn btn-secondary my-2"> No </a>
        </p>
      </div>
    </div>
    </div>
  </section>


</main>

<script src="/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

      
</body>
</html>
