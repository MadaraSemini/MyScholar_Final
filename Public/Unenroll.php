<?php

include_once("../Private/classes/User.php");
include_once("../Private/classes/student.php");
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

$student = $_SESSION['student'];
$class_id = $_GET['id'];

$student_id = $student->getId();

if(isset($_GET["yescls"]) && isset($_GET["yesstd"])){

    $cls_id = $_GET['yescls'];
    $std_id = $_GET['yesstd'];

    $connector = ConnectSingleton::getInstance();
    $con = $connector->getConnection();

    $sql = "SELECT * FROM student_class WHERE class_id='$cls_id' AND student_id='$std_id'";
    $result = mysqli_query($con, $sql);

    while($row = $result->fetch_assoc()):
      $student_class_id = $row['id'];
    endwhile;

    $sql2 = "DELETE FROM student_class WHERE id='$student_class_id'";
  
    echo '<script>alert("You removed this student! ")</script>';

    if (mysqli_query($con, $sql2)){

        $sql3 = "SELECT * from class WHERE Id='$cls_id'";
        $result3 = mysqli_query($con, $sql3);

        while($row3 = $result3->fetch_assoc()):
            $current_capacity = $row3['current_capacity'];
        endwhile;

        $newCurrCapacity = $current_capacity - 1;                  
        echo $newCurrCapacity;

        $sql4 = "UPDATE class SET current_capacity='$newCurrCapacity' WHERE Id='$cls_id'";
        $result4 = mysqli_query($con, $sql4);

        $_SESSION['obj'] = $student;
        $url = "dashboard.php";
        header('Location: '.$url); 

    }
    else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
}



if(isset($_GET["nocls"]) && isset($_GET["nostd"])){
    $cls_id = $_GET['nocls'];
    $_SESSION['student'] = $student;
    $url = "ClassPageForStudent.php?id=".$cls_id;
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
    <title> Unenroll </title>

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
        background-image: url("../Private/Images/unenroll2.jpg");
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
        <h1 class="fw-light"> <b> Unenroll </b> </h1>
        <p class="lead text-muted"> <b> Are you sure you want to unenroll from this class? </b> </p>
        <p>
          <a href="Unenroll.php?yescls=<?php echo $class_id?>&yesstd=<?php echo $student_id?>" class="btn btn-primary my-2"> Yes </a>
          <a href="Unenroll.php?nocls=<?php echo $class_id?>&nostd=<?php echo $student_id?>" class="btn btn-secondary my-2"> No </a>
        </p>
      </div>
    </div>
  </div>
  </section>

</main>

<script src="/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

      
</body>
</html>