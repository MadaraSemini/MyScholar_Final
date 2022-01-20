<?php
include_once("../Private/classes/User.php");
include_once("../Private/classes/student.php");
include_once("../Private/config/ConnectSingleton.php");

session_start();
$connector = ConnectSingleton::getInstance();
$connec = $connector->getConnection();
/*$connec=mysqli_connect("localhost","root","","myscholar");
    if(!$connec){
        echo("connection error".mysqli_connect_error()."<br/>");
        die();
    }*/



$sql = "SELECT * FROM student;";
$result = mysqli_query($connec, $sql);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);


$student=$_SESSION['obj'];
$id = $student->getId();
$username=$student->getUsername();
$grade=$student->getGrade();
$firstName=$student->getFirstName();
$lastName=$student->getLastName();
$fullname=$firstName." ".$lastName;
$photo_name=$student->getProfPhoto();
$email=$student->getEmail();
$district=$student->getDistrict();

if ($photo_name=="../Private/uploads/"){
    $photo_name = '../Private/uploads/default.jpg';
}


$logged = false;
if (isset($_SESSION['obj'])) {
    $logged = true;
    $student = $_SESSION['obj'];

    $id = $student->getId();
    $name = $student->getUsername();
} else {
    $logged = false;
}




$sql2 = "SELECT * FROM student_class;";
$result2 = mysqli_query($connec, $sql2);
$posts2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

$enrolled_classes = array();
foreach ($posts2 as $post2) :
    if ($post2["student_id"] == $id) {
        array_push($enrolled_classes, $post2["class_id"]);
    }

endforeach;


$sql3 = "SELECT * FROM class;";
$result3 = mysqli_query($connec, $sql3);
$posts3 = mysqli_fetch_all($result3, MYSQLI_ASSOC);







?>



<!-- line 64 and 67 dammoth css pissuwk wenwa -madara-->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
    <title>Profile page</title>
    <link rel="stylesheet" href="css/studentProfile.css" type="text/css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/logout.css">
    <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">
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
    <?php $_SESSION['obj']=$student ?>

    <div class="card">
        <img src="<?php echo $photo_name; ?>" alt="No photo uploaded" name="profile" width="300" height="300">
        <div class="details">
            <h1 class="username"><?php echo htmlspecialchars($username)  ?></h1><br />
            <h1 class="fullname" id="fullname"><?php echo htmlspecialchars($fullname)  ?></h1>
            <h3><?php echo "Grade ".htmlspecialchars($grade)  ?></h3>
            <a href="editStudentProfile.php">Edit profile</a>
        </div>
    </div>

    <div class="container">

        <div class="description">
            <h1 class="Des">Description</h1>
            <h2 class="des">Full Name :  <?php echo htmlspecialchars($fullname) ?></h2>
            
            <h2 class="des">Email : <?php echo htmlspecialchars($email) ?></h2>
            
            <h2 class="des">District : <?php echo htmlspecialchars($district) ?></h2>

            <h2 class="des">Grade :  <?php echo htmlspecialchars($grade) ?></h2>


            
        
        </div>

        <div class="classList">
            <h1 class="enrolledClasses">Your enrolled classes</h1>
            <div class="list">
                <?php foreach ($enrolled_classes as $enrolled_class) : ?>
                    <?php foreach ($posts3 as $class) : ?>
                        <?php if ($class['Id'] == $enrolled_class) { ?>
                            <li class="enrolled_class">
                                <?php $_SESSION['class_id'] = $enrolled_class;
                                      $_SESSION['student_id']  =$id;         ?>

                                <a href="ClassPageForStudent.php?id=<?php echo $enrolled_class?> " class="class_link"> <?php echo htmlspecialchars($class['subject'] . " Grade" . $class['grade']) ?></a>
                                
                            </li>
                        <?php } ?>
                    <?php endforeach ?>
                <?php endforeach; ?>
            </div>
            
        </div>

        
    </div>

    
    <!-- footer -->
    <!-- <div class="footer">
        <h2>Footer</h2>
    </div> -->

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

    <!--  -->
    <script>
        function gotoDashboard() {
            window.location.href = "dashboard.html";
        }
    </script>

    <?php
        mysqli_free_result($result);
        mysqli_free_result($result2);
        mysqli_free_result($result3);

        mysqli_close($connec);
    ?>

</body>

</html>