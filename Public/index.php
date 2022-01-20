<?php
include_once("../Private/classes/User.php");
include_once("../Private/classes/student.php");
include_once("../Private/classes/Teacher.php");
include_once("../Private/config/ConnectSingleton.php");
session_start();
// $connector = new Connector();
// $con = $connector->connectDatabase();
$connector = ConnectSingleton::getInstance();
$con = $connector->getConnection();

$logged = false;
if (isset($_SESSION['obj'])) {
    $logged = true;
    $student = $_SESSION['obj'];

    $id = $student->getId();
    $name = $student->getUsername();
} else {
    $logged = false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- links for counter -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="counter.js"></script> -->


    <link rel="stylesheet" href="css/counter.css">

    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/logout.css">
    <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">

    <title>Home</title>
</head>

<body>
    <div class="hero-image">
        <div class="hero-text">
            <p>Online private tutor and student information management system</p>
            <button onclick="document.location='studentLogin.php'" style="width:auto;">I'm a student</button>
            <button onclick="document.location='teacherLogin.php'" style="width:auto;">I'm a teacher</button>
        </div>
    </div>
    <div class="header">

        <!-- navigation bar -->
        <div class="topnav">
            <a href="index.php">Home</a>
            <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if ($student instanceof Student) { ?>href="dashboard.php" <?php } else { ?>href="teacherDashboard.php" <?php } ?>>Dashboard</a></div>
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


        <!-- About us -->
        <div class="aboutUs">
            <div class="flip-box">
                <div class="flip-box-inner">
                    <div class="flip-box-front">
                        <h2>What is My Scholar?</h2>
                    </div>
                    <div class="flip-box-back">
                        <p><b>MyScholar</b> is a student and tutor information mangement system that student can easily find tutors and tutors can easily reach to their students. Tutors can create and post advertiesments about their classes. Student can find a tutor for any subjects they want. <b>MyScholar</b> is the best solution for busy tutors manage their students. </p>
                    </div>
                </div>
            </div>
            <div class="flip-box">
                <div class="flip-box-inner">
                    <div class="flip-box-front">
                        <h2>Why My Scholar?</h2>
                    </div>
                    <div class="flip-box-back">
                        <p><b>MyScholar</b> is, </br> userfriendly</br> have more facilities than typical a LMS</br> free advertising </br> </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- counter -->
        <div class="container2">
            <div class="row">
                <div class="four col-md-3">
                    <div class="counter-box colored"> <i class="fa fa-group"></i> <span class="counter"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM student")); ?></span>
                        <p>Registered Students</p>
                    </div>
                </div>
                <div class="four col-md-3">
                    <div class="counter-box"> <i class="fa fa-group"></i> <span class="counter"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM teacher")); ?></span>
                        <p>Registered Teachers</p>
                    </div>
                </div>
                <div class="four col-md-3">
                    <div class="counter-box colored"> <i class="fa fa-book"></i> <span class="counter"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM class")); ?></span>
                        <p>Available Classes</p>
                    </div>
                </div>

                <div class="four col-md-3">
                    <div class="counter-box"> <i class="fa fa-book"></i> <span class="counter"><?php echo mysqli_num_rows(mysqli_query($con, "SELECT * FROM advertisement")); ?></span>
                        <p>Available Advertiesments</p>
                    </div>
                </div>

            </div>
        </div>


        <div class="footer">
            <h2>Footer</h2>
        </div>
</body>

</html>