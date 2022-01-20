<?php 

include_once("../Private/classes/User.php");
include_once("../Private/classes/Teacher.php");
include_once("../Private/config/ConnectSingleton.php");

session_start();
ob_start();
$logged = false;
if (isset($_SESSION['obj'])) {
$logged = true;
$user = $_SESSION['obj'];

$name = $user->getUsername();
} else {
    $logged = false;
}

$class_id = $_GET['id'];
$teacher = $_SESSION['teacher'];

$teacher_id = $teacher->getId();

$connector = ConnectSingleton::getInstance();
$con = $connector->getConnection();

$sql1 = "SELECT * FROM class WHERE Id='$class_id'";
$result1 = mysqli_query($con, $sql1);

while($row1 = mysqli_fetch_array($result1)){
    $day = $row1["day"];
    $starttime = $row1["starttime"];
    $endtime = $row1["endtime"];
    $fee = $row1["fee"];
    $classtype = $row1["classtype"];
    $capacity = $row1["capacity"];
    $location = $row1["location"];
}

$sql2 = "SELECT * FROM teacher WHERE Id='$teacher_id'";
$result2 = mysqli_query($con, $sql2);

while($row2 = mysqli_fetch_array($result2)){
    $contact_number = $row2["contact_number"];
}



if(isset($_POST["submit"])){
    if(!empty($_POST["day"]) && !empty($_POST["starttime"]) && !empty($_POST["endtime"]) && !empty($_POST["fee"]) && 
        !empty($_POST["classtype"]) && !empty($_POST["capacity"]) && !empty($_POST["contact"]) && !empty($_POST["location"])){

        $day = $_POST["day"];
        $starttime = $_POST["starttime"];
        $endtime = $_POST["endtime"];
        $fee = $_POST["fee"];
        $classtype = $_POST["classtype"];
        $capacity = $_POST["capacity"];
        $contact_number = $_POST["contact"];
        $location = $_POST["location"];
        
        $fee = mysqli_real_escape_string($con, $_POST['fee']);
        $capacity = mysqli_real_escape_string($con, $_POST['capacity']);
        $location = mysqli_real_escape_string($con, $_POST['location']);
        $contact_number = mysqli_real_escape_string($con, $_POST['contact']);


        $sql3 = "UPDATE class SET day='$day', starttime='$starttime', endtime='$endtime', classtype='$classtype', fee='$fee', location='$location', capacity='$capacity' WHERE Id='$class_id'";
        $result3 = mysqli_query($con,$sql3);

        $sql4 = "UPDATE teacher SET contact_number='$contact_number' WHERE Id='$teacher_id'";
        $result4 = mysqli_query($con,$sql4);


        $_SESSION['obj'] = $teacher;

        $url = "ClassPageForTeacher.php?id=".$class_id;
        header('Location: '.$url);
     
        mysqli_close($con);

    }

}


if(isset($_POST["cancel"])){
    $_SESSION['obj'] = $teacher;
    
    $url = "ClassPageForTeacher.php?id=".$class_id;
    header('Location: '.$url);
     
    mysqli_close($con);
}

ob_end_flush();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/logout.css">
    <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">

    <title> Update Class </title>
    <link rel="stylesheet" type="text/css" href="css/createClassPageForm.css">
    <link rel="stylesheet" href="css/theme.css">
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
        <h2 class="topic"><b> Update Class Info </b></h2>

        <form id="updateClassForm" action="UpdateClass.php?id=<?php echo $class_id?>" method="post">

            <label for="day"> Day </label>
            <select id="day" name="day" required>
                <?php 
                $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

                foreach ($days as $dayName){
                    if($dayName == $day){
                        ?> <option selected value="<?php echo $dayName?>"> <?php echo $dayName?> </option>
                    <?php
                    } 
                    else { ?>
                        <option value="<?php echo $dayName?>"> <?php echo $dayName?> </option>
                    <?php
                    }
                }
                ?>
            </select>

            <br><br><label> Time Period </label><br>
            <label for="from"> From : </label>
            <input type="time" id="starttime" value="<?php echo $starttime?>" name="starttime" required>
            <label for="to"> To : </label>
            <input type="time" id="endtime" value="<?php echo $endtime?>" name="endtime" required> <br> <br>

            <label for="fee"> Monthly Class Fee (in LKR) </label>
            <input type="number" id="fee" name="fee" min="0"  value="<?php echo $fee?>" placeholder="Enter the amount of monthly fee  (*required) " required>

            <label for="capacity"> Maximum Capacity </label>
            <input type="number" id="capacity" name="capacity" min="1" value="<?php echo $capacity?>" placeholder="Enter maximum no of students for the class" required>

            <label for="classtype"> Class Type </label>
            <select id="classtype" name="classtype" required>
            <?php 
                $types = array("Individual", "Group", "Hall");

                foreach ($types as $typeName){
                    if($typeName == $classtype){
                        ?> <option selected value="<?php echo $typeName?>"> <?php echo $typeName?> </option>
                    <?php
                    } 
                    else { ?>
                        <option value="<?php echo $typeName?>"> <?php echo $typeName?> </option>
                    <?php
                    }
                }
                ?>
            </select>

            <label for="contact">Contact number</label>
            <input type="text" id="contact" name="contact" value="<?php echo $contact_number?>" placeholder="REQUIRED unless you want to clear your contact number" required>

            <label for="location"> Location </label>
            <input type="text" id="location" name="location" value="<?php echo $location?>" placeholder="Enter the location where the physical class will be conducted    ex: Nugegoda" required>

            <button type="submit" id="submit_button" name="submit">submit</button>
            <button type="cancel" id="cancel-button" name="cancel">cancel</button>


        </form>

    </div>

</body>
</html>