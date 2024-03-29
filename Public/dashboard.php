<?php

include_once("../Private/classes/User.php");
include_once("../Private/classes/student.php");
include_once("../Private/classes/uploader.php");
include_once("../Private/config/ConnectSingleton.php");
session_start();

// $connector = new Connector();
// $connec = $connector->connectDatabase();
$connector = ConnectSingleton::getInstance();
$connec = $connector->getConnection();
$logged = false;
if (isset($_SESSION['obj'])) {

    $logged = true;
} else {
    $logged = false;
}


if (isset($_POST['logout'])) {
    session_destroy();
    header('location:index.php');
}

$student = $_SESSION['obj'];

$id = $student->getId();
$name = $student->getUsername();
$firtsname = $student->getFirstName();
$lastname = $student->getLastname();
$fullname = $firtsname . ' ' . $lastname;
$photo_name = $student->getProfPhoto();

$query = "select * from student_class WHERE student_id='$id'";
$query_run = mysqli_query($connec, $query);
$row1 = mysqli_fetch_all($query_run, MYSQLI_ASSOC);


$class_list = array();
$teacher_list = array();
$class_ids = array();
$teacher_ids = array();

if (is_array($row1)) {
    foreach ($row1 as $r1) :
        $calss_id = $r1['class_id'];
        array_push($class_ids, $calss_id);

        $query2 = "select * from class WHERE id='$calss_id'";
        $query_run2 = mysqli_query($connec, $query2);

        $row2 = $query_run2->fetch_array();
        $subject = $row2['subject'];
        if ($row2["grade"] == 'None') {
            $grade = $row2["grade"];
        } else {
            $grade = "Grade " . $row2["grade"];
        }
        $teacher_id = $row2['teacher_id'];
        array_push($teacher_ids, $teacher_id);

        $query3 = "select * from teacher WHERE id='$teacher_id'";
        $query_run3 = mysqli_query($connec, $query3);

        $row3 = $query_run3->fetch_array();

        $teacher_name = $row3['designation'] . " " . $row3['first_name'] . " " . $row3['last_name'];
        $class_detail = $subject . ' - ' . $grade .  ' - ' . $teacher_name;

        array_push($class_list, $class_detail);
        array_push($teacher_list, $teacher_name);

    endforeach;
}

$classlen = count($class_list);
$techlen = count($teacher_list);

// $posts=mysqli_fetch_all($query_run, MYSQLI_ASSOC);

// foreach($posts as $post):
//     $grade="Grade ".$post["grade"];
//     $fullname=$post['First_name']." ".$post["Last_name"];
//     $photo_name="uploads/".$post['profile_photo'];



// endforeach;


$msgquery = "select * from notification WHERE status=0 and receiver='$id' and availability=0";
$msgquery_run = mysqli_query($connec, $msgquery);
$count = mysqli_num_rows($msgquery_run);
$row1 = mysqli_fetch_all($msgquery_run, MYSQLI_ASSOC);

$_SESSION['student'] = $student;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">
    <link rel="stylesheet" href="css/logout.css">
    <link rel="stylesheet" href="css/studentDashboard.css">
    <title>DashBoard</title>
</head>

<body>
    <?php if ($logged) { ?>
        <script type="text/javascript">
            document.getElementById('idlg').style.display = 'block';
        </script>
    <?php } else { ?>
        <script type="text/javascript">
            document.getElementById('idlg').style.display = 'none';
        </script>
    <?php } ?>
    <!-- navigation bar -->
    <div class="topnav">
        <a id=id1 href="index.php">Home</a>
        <div id="idlg" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id3 style="float: right;" onclick="document.getElementById('id01').style.display='block'">Log out</a></div>




        <div id="id01" class="logout">
            <div class="logout_msg animate">
                <div class="top">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                </div>
                <h1>Log Out</h1>
                <p><?php echo $name ?> are you sure you want to log out?</p>
                <!-- <p>Are you sure you want to Log out?</p> -->
                <!-- <input type="button" class="yes" name="logout"  value="Yes"> -->
                <form action="dashboard.php" method="post">
                    <button id="log" type="submit" class="yes" name="logout">Yes</button>
                    <button id="log" type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">No</button>
                </form>


            </div>
        </div>

        <a style="float:right" id=id2 href="contactUs.php">Contact us</a>


    </div>




    <!-- Side navigation -->
    <div class="sidenav">
        <div class="userdetail">
            <img id="propic" src=<?php echo $photo_name ?> alt="No profilr photo" name="profile" width="100" height="100">
            <h3 id="fullname"><?php echo $fullname ?> </h3>

        </div>
        <button class="accordion">My Classes</button>
        <div class="panel">
            <?php if (is_array($class_list)) {
                for ($x = 0; $x < $classlen; $x++) :
            ?>

                    <a href="ClassPageForStudent.php?id=<?php echo $class_ids[$x] ?>">
                        <p><?php echo $class_list[$x] ?></p>
                    </a>
                <?php endfor;
            } else { ?>
                <p>No Classes</p>
            <?php } ?>
        </div>
        <?php ?>


        <!--
        <button class="accordion">My Teachers</button>
        <div class="panel">
            <?php //if (is_array($teacher_list)) {
            //for ($x = 0; $x < $techlen; $x++) :
            ?>
                    <a href="teacherProfile.php?id=<?php //echo $teacher_ids[$x]
                                                    ?>"><p><?php //echo $teacher_list[$x] 
                                                                                        ?></p></a>
                <?php //endfor;
                //} else { 
                ?>
                <p>No Teachers</p>
            <?php //} 
            ?>
        </div>
        -->


        <button class="accordion" onclick="location.href='StudentRequests.php'">My Requests</button>

    </div>

    <!-- Header -->
    <div class="left-container">
        <div class="header">
            <h1>Dashboard</h1>
            <div class="cards">
                

                <div class="card">
                    <h5 class="card-title">View profile</h2>
                    <img src="../Private/Images/man.png" alt="">
                    <button class="card-desc" onclick="location.href='studentProfile.php'"> Profile</button>
                </div>
                <div class="card">
                    <h5 class="card-title">View Advertisements</h2>
                    <img src="../Private/Images/ads-campaign.png" alt="">
                    <button class="card-desc" onclick="location.href='adCollectionWithFactory.php'" type="button"> Advertisements </button>
                </div>
            </div>
            <!-- <div class="dashboardcard">
            <button onclick="location.href='studentProfile.php'"> View profile</button>
            </div>
            <div class="dashboardcard">
            button to all advertisements
            <button onclick="location.href='adCollection.php'" type="button"> View Advertisements </button>
            </div> -->




        </div>
        <!-- <div class="class_list">
           // <?php //if (is_array($class_list)) {
                //for ($x = 0; $x < $classlen; $x++) : ?>
                    <div class="cls_container">

                        <a href="ClassPageForStudent.php?id=<?php //echo $class_ids[$x]  ?>" class="clsLink"><?php //echo $class_list[$x] ?></a>

                    </div>
            <?php //endfor;
            //} ?>
        </div> -->



        <!-- Notification -->
        <div class="notification">
            <div class="notification-button">
                <span id="notif" onclick="myFunction()" style="font-size:xx-large;"><i class="fa fa-envelope"></span></i><span class="badge"><?php echo $count ?></span>
            </div>

            <!-- <a href="#" > </a> -->
            <div class="notification-list " id="dd">
                <?php
                if ($count) {
                    if (is_array($row1)) {
                        foreach ($row1 as $r1) :
                            $notif_id = $r1['id'];
                            $notif_msg = $r1['message'];
                            $notif_request = $r1['request_id'];
                            // $query2 = "select * from class WHERE id='$calss_id'";
                            // $query_run2 = mysqli_query($connec, $query2);
                            // $row2 = $query_run2->fetch_array();
                            // $subject = $row2['subject'];
                            // $teacher_id = $row2['teacher_id'];
                            // $query3 = "select * from teacher WHERE id='$teacher_id'";
                            // $query_run3 = mysqli_query($connec, $query3);
                            // $row3 = $query_run3->fetch_array();
                            // $teacher_name = $row3['Username'];

                ?>
                            <a href="notifications.php?id=<?php echo $notif_id ?>"><?php echo $notif_msg; ?></a>


                <?php endforeach;
                    }
                } else {
                    echo ' <a class="notif-item" href="#">  No new notifications </a>';
                }
                ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="notifications.php?all=1">View all notifications</a>
            </div>

            </ul>
        </div>
    </div>
    </div>


    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                /* Toggle between adding and removing the "active" class,
                to highlight the button that controls the panel */
                this.classList.toggle("active");

                /* Toggle between hiding and showing the active panel */
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }


        function myFunction() {
            var x = document.getElementById("dd");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>

</body>

</html>