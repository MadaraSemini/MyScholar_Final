<?php

include_once("classes/User.php");
include_once("classes/student.php");
include_once("classes/connector.php");
//include_once("classes/ClassPage/ProxyClass.php");
//include_once("classes/ClassPage/RealClass.php");
include_once("classes/ClassPage/Class.php");

session_start();

$student = $_SESSION['student'];
$class_id = $_GET['id'];

$student_id = $student->getId();

if(isset($_GET["yescls"]) && isset($_GET["yesstd"])){

    $cls_id = $_GET['yescls'];
    $std_id = $_GET['yesstd'];

    $connector = new Connector();
    $con = $connector->connectDatabase();

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
    </style>

    
</head>
<body>

<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light"> Unenroll </h1>
        <p class="lead text-muted"> Are you sure you want to unenroll from this class? </p>
        <p>
          <a href="Unenroll.php?yescls=<?php echo $class_id?>&yesstd=<?php echo $student_id?>" class="btn btn-primary my-2"> Yes </a>
          <a href="Unenroll.php?nocls=<?php echo $class_id?>&nostd=<?php echo $student_id?>" class="btn btn-secondary my-2"> No </a>
        </p>
      </div>
    </div>
  </section>

</main>

<script src="/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

      
</body>
</html>