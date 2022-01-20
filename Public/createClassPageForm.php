<?php
    
    include_once("../Private/config/connector.php");
    include_once("../Private/classes/User.php");
    include_once("../Private/classes/Teacher.php");
    session_start();

    $logged = false;
    if (isset($_SESSION['obj'])) {
        $logged = true;
        $teacher = $_SESSION['obj'];
        $teacher_id = $teacher->getId();
        $name=$teacher->getUsername();
    } else {
        $logged = false;
    }

    
    if(isset($_POST["submit"])){
        if(!empty($_POST["subject"]) && !empty($_POST["day"]) && !empty($_POST["starttime"]) && !empty($_POST["grade"]) &&
        !empty($_POST["medium"]) && !empty($_POST["endtime"]) && !empty($_POST["fee"]) && !empty($_POST["classtype"]) && !empty($_POST["capacity"])){

            $subject = $_POST["subject"];
            $day = $_POST["day"];
            $starttime = $_POST["starttime"];
            $endtime = $_POST["endtime"];
            $fee = $_POST["fee"];
            $classtype = $_POST["classtype"];
            $grade = $_POST["grade"];
            $medium = $_POST["medium"];
            $capacity = $_POST["capacity"];

            $current_capacity = 0;


            if(!empty($_POST["location"])){
                $location = $_POST["location"];
            }else{
                $location = null;
            }

            $connector = new Connector();
            $con = $connector->connectDatabase();

            $subject = mysqli_real_escape_string($con, $_POST['subject']);
            $fee = mysqli_real_escape_string($con, $_POST['fee']);
            $capacity = mysqli_real_escape_string($con, $_POST['capacity']);
            $location = mysqli_real_escape_string($con, $_POST['location']);
            $current_capacity = mysqli_real_escape_string($con, $_POST['current_capacity']);


            $sql1 = "INSERT INTO class (teacher_id, subject, grade, medium, day, starttime, endtime, fee, capacity, classtype, location, current_capacity) 
                    VALUES ('$teacher_id', '$subject', '$grade', '$medium', '$day', '$starttime', '$endtime', '$fee', '$capacity', '$classtype', '$location', '$current_capacity')";

            
            if(mysqli_query($con,$sql1)){
                $class_id = mysqli_insert_id($con);

                $_SESSION['obj'] = $teacher;
                
                $url = "teacherDashboard.php";
                header('Location: '.$url);
                
                
            }else{
                echo("error".mysqli_error($con));
            }

            mysqli_close($con);

        }
    }

    if(isset($_POST["cancel"])){
        $_SESSION['obj'] = $teacher;

        $url = "teacherDashboard.php";
        header('Location: '.$url);
    }
    
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

    <title> Create a class </title>
    <link rel="stylesheet" type="text/css" href="css/createClassPageForm.css">
    <link rel="stylesheet" href="css/theme.css">

</head>


<body>
     <!-- navigation bar -->
     <div class="topnav">
            <a href="index.php">Home</a>
            <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if($teacher instanceof Student){?>href="dashboard.php"<?php }else{?>href="teacherDashboard.php"<?php }?>>Dashboard</a></div>
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
    <div class="container">
        <h2 class="topic"><b> Create Your Class Here </b></h2>
        <h5 class="condition">(Make sure to fill all the required items before submitting)</h6>

        <form id="cpForm" action="createClassPageForm.php" method="post">

            <label for="subject"> Subject</label>
            <input type="text" id="subject" name="subject"  placeholder="Enter subject  (*required) " required >

            <label for="grade"> Grade </label>
            <select id="grade" name="grade" required>
                <option selected="Default" aria-placeholder="None"> None </option>
                <option value="1"> Grade 1 </option>
                <option value="2"> Grade 2 </option>
                <option value="3"> Grade 3 </option>
                <option value="4"> Grade 4 </option>
                <option value="5"> Grade 5 </option>
                <option value="6"> Grade 6 </option>
                <option value="7"> Grade 7 </option>
                <option value="8"> Grade 8 </option>
                <option value="9"> Grade 9 </option>
                <option value="10"> Grade 10 </option>
                <option value="11"> Grade 11 </option>
                <option value="12"> Grade 12 </option>
                <option value="13"> Grade 13 </option>
            </select>

            <label for="medium"> Medium </label>
            <select id="medium" name="medium" required>
                <option selected="Default" aria-placeholder="None"> None </option>
                <option value="Sinhala"> Sinhala medium </option>
                <option value="English"> English medium </option>
                <option value="Tamil"> Tamil medium </option>
            </select>

            <label for="day"> Day </label>
            <select id="day" name="day" required>
                <option selected value="Monday"> Monday </option>
                <option value="Tuesday"> Tuesday </option>
                <option value="Wednesday"> Wednesday </option>
                <option value="Thursday"> Thursday </option>
                <option value="Friday"> Friday </option>
                <option value="Saturday"> Saturday </option>
                <option value="Sunday"> Sunday </option>
            </select>

            <br><br><label> Time Period </label><br>
            <label for="from"> From : </label>
            <input type="time" id="starttime" name="starttime" required>
            <label for="to"> To : </label>
            <input type="time" id="endtime" name="endtime" required> <br> <br>

            <label for="fee"> Monthly Class Fee (in LKR) </label>
            <input type="number" id="fee" name="fee" min="0"  placeholder="Enter the amount of monthly fee  (*required) " required>

            <label for="capacity"> Maximum Capacity </label>
            <input type="number" id="capacity" name="capacity" min="1" placeholder="Enter maximum no of students for the class" required>

            <label for="classtype"> Class Type </label>
            <select id="classtype" name="classtype" required>
                <option selected value="Individual"> Individual class </option>
                <option value="Group"> Group class </option>
                <option value="Hall"> Hall class </option>
            </select>

            <label for="location"> Location </label>
            <input type="text" id="location" name="location"  placeholder="Enter the location where the physical class will be conducted    ex: Nugegoda">

            <button type="submit" id="submit_button" name="submit">submit</button>
            <button type="cancel" id="cancel-button" name="cancel">cancel</button>


        </form>

    </div>

</body>
</html>