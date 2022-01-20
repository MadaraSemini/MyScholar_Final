<?php
include_once("../Private/classes/User.php");
include_once("../Private/classes/student.php");
include_once("../Private/classes/Teacher.php");
include_once("../Private/config/ConnectSingleton.php");
session_start();

// $connector = new Connector();
// $connec = $connector->connectDatabase();
$connector = ConnectSingleton::getInstance();
$connec = $connector->getConnection();
$logged = false;

if (isset($_SESSION['obj'])) {

    $logged = true;
    $student = $_SESSION['obj'];
    $id=$student->getId();
    $name=$student->getUsername();
} else {
    $logged = false;
}

if (isset($_GET['id'])) {
    $mainid = $_GET['id'];

    $updat_query = "update notification SET status=1 WHERE id='$mainid'";
    $sql_update = mysqli_query($connec, $updat_query);
}
elseif(isset($_GET['all'])){
    $updat_query = "update notification SET status=1 ";
    $sql_update = mysqli_query($connec, $updat_query);
}
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
    <link rel="stylesheet" href="css/notification.css">
    <title>Notifications</title>
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
        <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if ($student instanceof Student) { ?>href="dashboard.php" <?php } else { ?>href="teacherDashboard.php" <?php } ?>>Dashboard</a></div>




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


    <!-- notification table -->
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Message</th>
                    <th>Class</th>
                    <th>Sender</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "select * from notification WHERE receiver='$id' and availability=0";
                $query_run = mysqli_query($connec, $query);
                $rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

                if (is_array($rows)) {
                    foreach ($rows as $row) :
                        $class_id = $row['class_id'];

                        $query2 = "select * from class WHERE id='$class_id'";
                        $query_run2 = mysqli_query($connec, $query2);

                        $row2 = $query_run2->fetch_array();
                        $subject = $row2['subject'];
                        if ($row2["grade"] == 'None') {
                            $grade = $row2["grade"];
                        } else {
                            $grade = "Grade " . $row2["grade"];
                        }
                        $sender_id = $row['sender'];
                        if ($student instanceof Student) {  
                            $query3 = "select * from teacher WHERE id='$sender_id'";
                            $query_run3 = mysqli_query($connec, $query3);
    
                            $row3 = $query_run3->fetch_array();
    
                            $sender_name = $row3['designation'] . " " . $row3['last_name'];
                        } 
                        else { 
                            $query3 = "select * from student WHERE id='$sender_id'";
                            $query_run3 = mysqli_query($connec, $query3);
    
                            $row3 = $query_run3->fetch_array();
    
                            $sender_name = $row3['First_name'] . " " . $row3['Last_name'];
                         } 

                        // $query3 = "select * from teacher WHERE id='$sender_id'";
                        // $query_run3 = mysqli_query($connec, $query3);

                        // $row3 = $query_run3->fetch_array();

                        // $teacher_name = $row3['designation'] . " " . $row3['last_name'];
                ?>

                        <tr <?php if ($row['status'] == 0) { ?> style="font-weight: bold;" <?php } ?>>
                            <td><?php echo $row['cr_date'] ?></td>
                            <td><?php echo $row['message'] ?></td>
                            <td><?php echo $subject." ".$grade ?></td>
                            <td><?php echo $sender_name ?></td>
                            <td><a href="deletenotif.php?id= <?php echo $row['id']  ?>" style="color: red "><i class="fa fa-trash-o" aria-hidden="true" style="font-size: x-large;"></i></a></td>
                        </tr>
                <?php endforeach;
                } else {
                    echo 'No notifications?';
                } ?>
            <tbody>
        </table>
    </div>


</body>

</html>