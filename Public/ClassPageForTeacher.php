<?php 
 
include_once("../Private/classes/User.php");
include_once("../Private/classes/Teacher.php");
include_once("../Private/config/ConnectSingleton.php");
include_once("../Private/classes/FactoryDP/Class.php");
include_once("../Private/classes/FactoryDP/ClassFactory.php");

session_start();
$logged = false;
if (isset($_SESSION['obj'])) {
$logged = true;
$user = $_SESSION['obj'];

$name = $user->getUsername();
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
    <title> Class Page For Teacher </title>
    <link rel="stylesheet" href="css/ClassPageForTeacher.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/logout.css">
    <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">
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

    <?php 
    
        $connector = ConnectSingleton::getInstance();
        $connec = $connector->getConnection();
        
        $id = $_GET['id'];
        $ClassFactory = new ClassFactory();
        $class = $ClassFactory->anOperation2($id);

        //$id = $_SESSION['class_id'];
        $teacher = $_SESSION['obj'];

        $t_id = $teacher->getId();

        //$id = $class->getId();

        $grade = $class->getGrade();
        $medium = $class->getMedium();
        $subject = $class->getSubject();
        $location = $class->getLocation();
        $day = $class->getDay();
        $starttime = $class->getStarttime();
        $endtime = $class->getEndtime();
        $classtype = $class->getClasstype();
        $fee = $class->getFee();
        //$teacher_id = $class->getTeacherId();

        if($grade == 'None'){
            $coursename = $subject;
        } else {
            $coursename = $subject." - Grade ".$grade;
        }

        $subject = $subject;

        if($grade == 'None'){
            //
        } else {
            $grade = "Grade ".$grade;
        }
            
        if($medium == 'None'){
            //
        } else {
            $medium = $medium." Medium";
        }

        if(strlen($location)== 0){
            $location = " -";
        } else {
            //
        }
            
        $classtype = $classtype." Class";
        $fee = "Rs ".$fee;
        

        $query2 = "SELECT * FROM teacher WHERE Id='$t_id'";
        $query_run2 = mysqli_query($connec, $query2);

        while($row = mysqli_fetch_array($query_run2)){
            $fullname = $row['designation']." ".$row['first_name']." ".$row['last_name'];
            $contact_number = $row['contact_number'];
        }


        $anouncements = $class->getAnouncements();
        $coursenotes = $class->getCoursenotes();
        
        /*
        $sql = "SELECT * FROM anouncement WHERE class_id='$id'";
        $result = mysqli_query($connec, $sql);
        $anouncements = array();

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $anouncements[] = $row;
            }
        }


        $sql2 = "SELECT * FROM coursenote WHERE class_id='$id'";
        $result2 = mysqli_query($connec, $sql2);
        $coursenotes = array();

        if(mysqli_num_rows($result2) > 0){
            while($row = mysqli_fetch_assoc($result2)){
                $coursenotes[] = $row;
            }
        }
        */

        mysqli_close($connec);

    ?>


    <!--
    <div class="navbar">
        <a href="index.php"> <img src="Images/logo2.png" alt="HomePage" width="140" height="50"></a>
        <a href="teacherProfile.html" class="right"> My Profile </a>
    </div>
    -->

    <div class="header">
        <h1> <?php echo htmlspecialchars($coursename) ?> </h1>
    </div>

    <div class="row">
        <div class="side">
            <h3> About Class </h3>
            <p> <b> Subject : </b> <?php echo htmlspecialchars($subject) ?> </p>
            <p> <b> Grade </b> : <?php echo htmlspecialchars($grade) ?> </p>
            <p> <b> Medium : </b> <?php echo htmlspecialchars($medium) ?> </p>
            <p> <b> Day :  </b> <?php echo htmlspecialchars($day) ?> </p>
            <P> <b> Start time : </b> <?php echo htmlspecialchars($starttime) ?> </P>
            <P> <b> End time :  </b> <?php echo htmlspecialchars($endtime) ?> </P>
            <p> <b> Class type : </b> <?php echo htmlspecialchars($classtype) ?> </p>
            <p> <b> Class fee : </b> <?php echo htmlspecialchars($fee) ?> </p>
            <p> <b> Location : </b> <?php echo htmlspecialchars($location) ?> </p>
            <p> <b> Conducted by : </b> <?php echo htmlspecialchars($fullname) ?> </p>
            <p> <b> Contact no : </b> <?php echo htmlspecialchars($contact_number) ?> </p>
            <br>
            
            <?php  
            $_SESSION['teacher'] = $teacher;
            ?>
            <a class="editbtn" href="UpdateClass.php?id=<?php echo $id?>"> Update Class </a> <br> <br>
            
            <?php 
            $_SESSION['teacher'] = $teacher;
            ?>
            <a class="editbtn" href="ViewStudentList2.php?id=<?php echo $id?>"> View Student List </a> <br> <br>
            
            <?php 
            $_SESSION['teacher'] = $teacher;
            ?>
            <a class="editbtn" href="DeleteClass.php?id=<?php echo $id?>"> Delete Class </a> <br>
        
        </div>
        <div class="main">
            <?php 
             
            
            ?>

            <div>
                <?php $_SESSION['teacher'] = $teacher; ?>
                <h3> Announcements </h3>
                <div class="anouncements">

                    <?php foreach($anouncements as $anouncement){ ?>
                        <li>
                            <?php echo $anouncement['anouncement']."  :  ".$anouncement['date']."\n"; ?>
                        </li>
                    <?php } ?>
                    <br>
                    <a class="editbtn" href="addAnouncementForm.php?id=<?php echo $id?>"> Add Announcements </a> <br> <br> <br>
                </div>
            </div>
            <div>
                <?php $_SESSION['teacher'] = $teacher; ?>
                <h3> Course Notes </h3>
                <div class="courseNotes">

                    <?php foreach($coursenotes as $coursenote){ 
                        $title = $coursenote['title'];
                        $file = "../Private/CourseNotes/".$coursenote['file'];
                    ?>
                        <li>
                            <a id="file" href="<?php echo $file; ?>" target="_blank"> <?php echo $title;?> </a>
                        </li>
                    <?php } ?>
                    <br>
                    <a class="editbtn" href="addCourseNoteForm.php?id=<?php echo $id?>"> Add Course Notes </a> <br> <br> <br>
                </div>
            </div>
        </div>
    </div>


    <!-- footer -->
    <div class="footer">
        <h2>Footer</h2>
    </div>

    <!-- responsive navigation bar -->
    <script>
        function myFunction() {
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav") {
            x.className += " responsive";
          } else {
            x.className = "topnav";
          }
        }
    </script>
</body>
</html>