<?php

    include_once("../private/classes/User.php");
    include_once("../private/classes/student.php");
    include_once("../Private/config/ConnectSingleton.php");
    include_once("../Private/classes/uploader.php");

    session_start();
    
    $logged = false;
    if (isset($_SESSION['obj'])) {
        $logged = true;
        $student = $_SESSION['obj'];

        $id = $student->getId();
        $name = $student->getUsername();
    } else {
        $logged = false;
    }

    

    $student=$_SESSION['obj'];

    $id = $student->getId();
    $username=$student->getUsername();
    $email=$student->getEmail();
    $grade=$student->getGrade();
    $district=$student->getDistrict();
    $firstName=$student->getFirstName();
    $lastName=$student->getLastName();
    $fullname=$firstName." ".$lastName;
    $photo_name=$student->getProfPhoto();
    $password=$student->getPassword();


    if(isset($_POST["submit"])){
        if(!empty($_POST["Firstname"])&& !empty($_POST["Lastname"]) && !empty($_POST["name"])  && !empty($_POST["email"]) && !empty($_POST["district"])){
            
            
            
                $firstName=$_POST["Firstname"];
                $lastName=$_POST["Lastname"];
                $username=$_POST["name"];
                
                $email=$_POST["email"];
                $district=$_POST["district"];
                $fullname=$firstName." ".$lastName;
                
                $encrypted_password;

                //echo $first_Name;
    
                //$student=new Student($first_name,$last_name,$username,$encrypted_password,$email,$district);
                //Create only when the data is in the database
    
                
    
                //$student=new Student($firt_name,$last_name,$username,$password,$email,$district);
                if(!empty($_POST["password"])){
                    $password=$_POST["password"];
                    $encrypted_password=md5($password);
                    $student->setPassword($encrypted_password);
                }else{
                    $encrypted_password=$password;
                }


                if(($_POST["grade"])!="None"){
                    $grade=$_POST["grade"];
                    $student->setGrade($grade);
                }

                $student->setFirstName($firstName);
                $student->setLastName($lastName);
                $student->setUsername($username);
                
                $student->setEmail($email);
                $student->setDistrict($district);
                //$student->setGrade($grade);

                //$file_uploader;
                // $str_arr = explode ("/", $photo_name);
                // $filename=$str_arr[1];
                // //$filename = $_FILES["image"]["name"];
                // $tempname=$_FILES["image"]["tmp_name"];
                // $folder = "uploads/".$filename; 

                
                
    
               

    
                
                
                   
                //$folder = "uploads/".$filename;
                          
    
    
                $connector = ConnectSingleton::getInstance();
                $connec = $connector->getConnection();
               
                /*$connec=mysqli_connect("localhost","root","","myscholar");
                if(!$connec){
                    echo("connection error".mysqli_connect_error()."<br/>");
                    die();
                }else{
        
                }*/
    
                // $firstName=mysqli_real_escape_string($connec,"$first_name");
                // $lastName=mysqli_real_escape_string($connec,"$last_name");
                // $username=mysqli_real_escape_string($connec,"$username");
                // $password=mysqli_real_escape_string($connec,"$password");
                // $email=mysqli_real_escape_string($connec,"$email");
                // $grade=mysqli_real_escape_string($connec,"$grade");
                // $district=mysqli_real_escape_string($connec,"$district");
                // $filename=mysqli_real_escape_string($connec,"$filename");
               
                
                
    
    
    
                //$sql="INSERT INTO student(First_name, Last_name, Username, passkey, email, grade, District, profile_photo) VALUES('$first_name','$last_name','$username', '$encrypted_password', '$email', '$grade', '$district', '$filename');";
                $sql="UPDATE student SET First_name = '$firstName', Last_name = '$lastName', Username='$username', passkey='$encrypted_password', email='$email', grade='$grade', District='$district' WHERE id='$id'";

                if($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 0){
                    $str_arr = explode ("/", $photo_name);
                    $filename=$str_arr[1];
                    //$filename = $_FILES["image"]["name"];
                    $tempname=$_FILES["image"]["tmp_name"];
                    $folder = $photo_name; 

                    $file_uploader=new Uploader($filename,$tempname,$folder);

                    $sql1="UPDATE student SET  profile_photo='$filename' WHERE id='$id'";
                
                    $file_uploader->uploadImage();

                    if(mysqli_query($connec,$sql1)){
                        echo("successfull");
                        //header("Location: studentProfile.php");
                    }else{
                        echo("error".mysqli_error($connec));
                    }
                         

                }else{
                    
                    $filename = $_FILES["image"]["name"];
                    $tempname = $_FILES["image"]["tmp_name"];
                    $folder = "../Private/uploads/".$filename; 

                    
                    $student->setProfPhoto($folder);  
                    $photo_name=$student->getProfPhoto();

                    $file_uploader=new Uploader($filename,$tempname,$folder);

                    $sql1="UPDATE student SET  profile_photo='$filename' WHERE id='$id'";
                
                    $file_uploader->uploadImage();

                    if(mysqli_query($connec,$sql1)){
                        //echo("successfull");
                        //header("Location: studentProfile.php");
                    }else{
                        echo("error".mysqli_error($connec));
                    }

                }
                
    
                
    
                if(mysqli_query($connec,$sql)){
                    //echo("successfull");
                    //header("Location: studentProfile.php");
                }else{
                    echo("error".mysqli_error($connec));
                }
                


                
                
                mysqli_close($connec);
    
            }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/studentForm.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/logout.css">
    <link rel="stylesheet" href="cs/theme.css">
    <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">
    <title>Edit Profile</title>
    
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

<div class="container">
        <h2 class="topic"><b>Student Register Form</b></h2>
        <h5 class="condition">(Make sure to fill all the required before submitting)</h6>
        <form id="rForm" action="editStudentProfile.php" method="post" enctype="multipart/form-data">

          <label for="Fullname">Name</label><br/>
          <input type="text"  name="Firstname" id="Firstname"  placeholder="First name" value=<?php echo htmlspecialchars($firstName) ?> required>

          <input type="text" name="Lastname" placeholder="Last name" id="lastName" value=<?php echo htmlspecialchars($lastName) ?> required><br/>
      
          <label for="name">User Name</label>
          <input type="text" id="name" name="name"  placeholder="Your user name.." value=<?php echo htmlspecialchars($username) ?> required >
      
          <label for="password">Password</label><br/>
          <input type="password" id="password" name="password" placeholder="Enter a password" >

          <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" ><br/>


          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter a valid email.." value=<?php echo htmlspecialchars($email) ?> required>

          
      
          <label for="grade">Grade</label><br>
          <select id="grade" name="grade"  required>
            
            <option value="None">None</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>

          </select><br>

          <label for="district">District</label><br>
          <input type="text" id="district" name="district"  placeholder="Your district.." value=<?php echo htmlspecialchars($district) ?> required>
      
          <label for="image">Profile Photo:</label>
          <input id="image" type="file" name="image">


          <button type="submit" id="submit_button" name="submit"  >submit</button>
          <button type="cancel" id="cancel-button" class="cl">cancel</button>

        </form>
      </div>
      <script src="studentForm.js"></script>

      <script type="text/javascript">

            function Validate() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
            }

      </script>
</body>
</body>
</html>