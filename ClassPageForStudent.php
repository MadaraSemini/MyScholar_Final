<?php 
include_once("classes/User.php");
include_once("classes/Teacher.php");
include_once("classes/student.php");
include_once("classes/connector.php");
// include_once("classes/ClassPage/ProxyClass.php");
// include_once("classes/ClassPage/RealClass.php");
include_once("classes/ClassPage/Class.php");
//------------------------------
include_once("classes/rating.php");
//------------------------------

session_start(); 


$connector = new Connector();
$connec = $connector->connectDatabase();

$logged = false;
if (isset($_SESSION['obj'])) {
    $logged = true;
    $student = $_SESSION['obj'];

    $name = $student->getUsername();
} else {
    $logged = false;
}

$id = $_GET['id'];

$student_id=$student->getId();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
    <title> Class Page For Student </title>
    <link rel="stylesheet" href="ClassPageForStudent.css">
    <link rel="stylesheet" href="theme.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="temporary.css">
    <link rel="stylesheet" href="logout.css">
    <link rel="icon" type="image/x-icon" href="Images/icon.png">
</head>
<body>
    <!-- navigation bar -->
    <div class="topnav">
            <a href="index.php">Home</a>
            <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if($student instanceof Student){?>href="dashboard.php"<?php }else{?>href="teacherDashboard.php"<?php }?>>Dashboard</a></div>
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
        
        

        $query1 = "SELECT * FROM class WHERE Id='$id'";
        $query_run1 = mysqli_query($connec, $query1);

        while($row = mysqli_fetch_array($query_run1)){
            if($row["grade"] == 'None'){
                $coursename = $row["subject"];
            } else {
                $coursename = $row["subject"]." - Grade ".$row["grade"];
            }

            $subject = $row["subject"];

            if($row["grade"] == 'None'){
                $grade = $row["grade"];
            } else {
                $grade = "Grade ".$row["grade"];
            }
            
            if($row["medium"] == 'None'){
                $medium = $row["medium"];
            } else {
                $medium = $row["medium"]." Medium";
            }

            if(strlen($row["location"])== 0){
                $location = " -";
            } else {
                $location = $row["location"];
            }
            
            $day = $row["day"];
            $starttime = $row["starttime"];
            $endtime = $row["endtime"];
            $classtype = $row["classtype"]." Class";
            $fee = "Rs ".$row["fee"];
            $teacher_id = $row['teacher_id'];
        }

        $query2 = "SELECT * FROM teacher WHERE Id='$teacher_id'";
        $query_run2 = mysqli_query($connec, $query2);

        while($row = mysqli_fetch_array($query_run2)){
            $fullname = $row['designation']." ".$row['first_name']." ".$row['last_name'];
            $contact_number = $row['contact_number'];
        }

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


        //--------------------------
        
        
        //$value;
        if(isset($_POST["buttons"])){

                
            $value= $_POST['buttons'];
        
            $rating=new Rating($teacher_id);
            $rating->setRating($value);
            $sql4="INSERT INTO star_rating(teacher_id,rating,student_id) VALUES('$teacher_id','$value','$student_id');";

                if(mysqli_query($connec,$sql4)){
                    //echo("successfull");
                    //header("Location: studentLogin.php");
                }else{
                    echo("error".mysqli_error($connec));
                }
            
        }

        

        
     
        
            


                

        
        //--------------------------


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
            
            <br><br>

            <?php 
            $_SESSION['student'] = $student;
            ?>
            <a class="editbtn" href="Unenroll.php?id=<?php echo $id?>"> Unenroll </a> <br><br>
            
            <button type="button" class="rateButton" onclick="document.getElementById('id03').style.display='block'">Rate the teacher</button>
            
            <!-- <form action="ClassPageForStudent.php" method="post">

                <button type="button" name="buttons" value="1" onclick="document.getElementById('id01').style.display='block'">1</button>
                <button type="button" name="buttons" value="2" onclick="document.getElementById('id01').style.display='block'">2</button>
                <button type="button" name="buttons" value="3" onclick="document.getElementById('id01').style.display='block'">3</button>
                <button type="button" name="buttons" value="4" onclick="document.getElementById('id01').style.display='block'">4</button>
                <button type="button" name="buttons" value="5" onclick="document.getElementById('id01').style.display='block'">5</button>



            </form> -->



            <div id="id03" class="ratingConfirm">
                <div class="logout_msg animate">
                    <div class="top">
                        <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    
                    <p>are you sure you want to rate?</p>
                    <!-- <p>Are you sure you want to Log out?</p> -->
                    <!-- <input type="button" class="yes" name="logout"  value="Yes"> -->
                    <form action="ClassPageForStudent.php?id=<?php echo $id   ?>" method="post">
                    <button class="ratebutton" type="submit" name="buttons" value="1" >1</button>
                    <button class="ratebutton" type="submit" name="buttons" value="2" >2</button>
                    <button class="ratebutton" type="submit" name="buttons" value="3" >3</button>
                    <button class="ratebutton" type="submit" name="buttons" value="4" >4</button>
                    <button class="ratebutton" type="submit" name="buttons" value="5" >5</button>


                    
                    <button id="log" type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">No</button>
                    </form>
                    

                </div>
                    
            </div>
        
        </div>
        <div class="main">
            <?php 
            
            $_SESSION['class_id'] = $id; 
            
            ?>

            <div>
                <h3> Anouncements </h3>
                <div class="anouncements">

                    <?php foreach($anouncements as $anouncement){ ?>
                        <li>
                        <?php echo $anouncement['anouncement']."  :  ".$anouncement['date']."\n"; ?>
                        </li>
                    <?php } ?>
                    <br> <br>
                </div>
            </div>
            <div>
                <?php $_SESSION['class_id'] = $id; ?>
                <h3> Course Notes </h3>
                <div class="courseNotes">

                    <?php foreach($coursenotes as $coursenote){ 
                        $title = $coursenote['title'];
                        $file = "CourseNotes/".$coursenote['file'];
                    ?>
                        <li>
                            <a id="file" href="<?php echo $file; ?>" target="_blank"> <?php echo $title;?> </a>
                        </li>
                    <?php } ?>
                    <br> <br>
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