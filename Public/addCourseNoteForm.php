<?php

include_once("../Private/classes/User.php");
include_once("../Private/classes/Teacher.php");
include_once("../Private/config/ConnectSingleton.php");

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


if(isset($_POST["submit"])){
    if(!empty($_POST["title"])){

    $title = $_POST["title"];

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    if($fileError === 0){
        $fileNameNew = uniqid('',true).".".$fileActualExt ;  // setting a unique name to the file
        $fileDestination = '../Private/CourseNotes/'.$fileNameNew ;
        move_uploaded_file($fileTmpName,$fileDestination);
    }
    

    $connector = new Connector();
    $con = $connector->connectDatabase();

    $title = mysqli_real_escape_string($con, "$title");
    $fileNameNew = mysqli_real_escape_string($con, "$fileNameNew");

    $sql = "INSERT INTO coursenote(class_id, title, file) VALUES ('$class_id','$title','$fileNameNew')";

    if ($con->query($sql) === TRUE) {
        $_SESSION['obj'] = $teacher;
        $url = "ClassPageForTeacher.php?id=".$class_id;
        header('Location: '.$url);
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
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
    <title>Add Course Notes</title>
    <link rel="stylesheet" href="css/addCourseNoteForm.css">
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
    <div class="container">
        <form id="CourseNoteForm" action="addCourseNoteForm.php?id=<?php echo $class_id?>" method="post" enctype="multipart/form-data">
            <h2 class="topic"><b> Add Course Notes </b></h2> <br> <br>

            <label for="title"> Title </label>
            <input type="text" id="title" name="title"  placeholder="Enter a title for your file..." required>

            <input type="file" id="file" name="file" required>
            <!-- <label for="file"> Choose a file </label> -->

            <br> <br><br> <br>

            <button type="submit" id="submit_button" name="submit">submit</button>
            <button type="cancel" id="cancel-button" name="cancel">cancel</button>
        </form>

    </div>
</body>
</html>