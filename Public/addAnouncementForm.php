<?php

include_once("classes/User.php");
include_once("classes/Teacher.php");
include_once("classes/connector.php");

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

$connector = new Connector();
$conn = $connector->connectDatabase();


if(isset($_POST["submit"])){
    if(!empty($_POST["anouncement"])){

        $anouncement = $_POST["anouncement"];

        $anouncement = mysqli_real_escape_string($conn, $_POST['anouncement']);
        $date = date("Y-m-d");

        $sql1 = "INSERT INTO anouncement (class_id, anouncement,date) 
                VALUES ('$class_id', '$anouncement','$date')";

        if ($conn->query($sql1) === TRUE) {
            $_SESSION['obj'] = $teacher;
            $url = "ClassPageForTeacher.php?id=".$class_id;
            header('Location: '.$url);
        } else {
            echo "Error: " . $sql1 . "<br>" . $conn->error;
        }

    }
}

if(isset($_POST["cancel"])){
    $_SESSION['obj'] = $teacher;
    $url = "ClassPageForTeacher.php?id=".$class_id;
    header('Location: '.$url);
}





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Announcements</title>
    <link rel="stylesheet" href="addAnouncementForm.css">
    <link rel="stylesheet" href="theme.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="logout.css">
    <link rel="icon" type="image/x-icon" href="Images/icon.png">
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
    <div class="container">
        <form id="AnouncementForm" action="addAnouncementForm.php?id=<?php echo $class_id?>" method="post">
            <h2 class="topic"><b> Add Announcement </b></h2>

            <label for="anouncement"> </label><br>
            <textarea id="anouncement" name="anouncement" placeholder="Enter anouncement..." style="height: 200px;" required></textarea> <br>

            <button type="submit" id="submit_button" name="submit">submit</button>
            <button type="cancel" id="cancel-button" name="cancel">cancel</button>
        </form>

    </div>
</body>
</html>