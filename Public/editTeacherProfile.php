<?php

    include_once("../Private/classes/User.php");
    include_once("../Private/classes/teacher.php");
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

    

    $teacher=$_SESSION['obj'];

    $id = $teacher->getId();
    $username=$teacher->getUsername();
    $designation=$teacher->getDesignation();
    $firstName=$teacher->getFirstName();
    $lastName=$teacher->getLastName();
    $fullname=$designation.". ".$firstName." ".$lastName;
    $photo_name=$teacher->getProfPhoto();
    $description=$teacher->getDescription();
    $contact_number=$teacher->getContactNumber();
    $district=$teacher->getDistrict();
    $email=$teacher->getEmail();
    $password=$teacher->getPassword();

    if(isset($_POST["submit"])){
        if(!empty($_POST["Firstname"])&& !empty($_POST["Lastname"]) && !empty($_POST["name"])  && !empty($_POST["email"]) && !empty($_POST["district"]) && !empty($_POST["contact"])){
            $firstName=$_POST["Firstname"];
            $lastName=$_POST["Lastname"];
            $username=$_POST["name"];
            $contact_number=$_POST["contact"];
            $email=$_POST["email"];
            $district=$_POST["district"];
            $fullname=$firstName." ".$lastName;
            $designation=$_POST["displayingName"];
            $description=$_POST["discription"];
            $encrypted_password;

            if(!empty($_POST["password"])){
                $password=$_POST["password"];
                $encrypted_password=md5($password);
                $teacher->setPassword($encrypted_password);
            }else{
                $encrypted_password=$password;
            }


            if(!empty($_POST["discription"])){
                $description=$_POST["discription"];
                $teacher->setDescription($description);
            }

            $teacher->setFirstName($firstName);
            $teacher->setLastName($lastName);
            $teacher->setUsername($username);
            $teacher->setDesignation($designation);   
            $teacher->setEmail($email);
            $teacher->setDistrict($district);
            $teacher->setContactNumber($contact_number);


            
            
            


            $connector = ConnectSingleton::getInstance();
            $connec = $connector->getConnection();



            if($_FILES['image']['size'] == 0 && $_FILES['image']['error'] == 0){
                $sql="UPDATE teacher SET designation='$designation', first_name = '$firstName', last_name = '$lastName', Username='$username', passkey='$encrypted_password', email='$email', District='$district',contact_number='$contact_number', description='$description' WHERE Id='$id'";

                if(mysqli_query($connec,$sql)){
                    //echo("successfull");
                    header("Location: teacherProfile.php");
                }else{
                    echo("error".mysqli_error($connec));
                }
                    
            }else{
                $filename = $_FILES["image"]["name"];
                $tempname = $_FILES["image"]["tmp_name"];
                $folder = "../Private/uploads/".$filename; 
                $teacher->setProfPhoto($folder);  
                $photo_name=$teacher->getProfPhoto();
                $file_uploader=new Uploader($filename,$tempname,$folder);

                $sql1="UPDATE teacher SET designation='$designation', first_name = '$firstName', last_name = '$lastName', Username='$username', passkey='$encrypted_password', email='$email', District='$district',contact_number='$contact_number', profile_photo='$filename', description='$description' WHERE ID='$id'";
                $file_uploader->uploadImage();

                if(mysqli_query($connec,$sql1)){
                    //echo("successfull");
                    header("Location: teacherProfile.php");
                }else{
                    echo("error".mysqli_error($connec));
                }
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
    <title>Edir Profile</title>
    <link rel="stylesheet" href="css/teacherForm.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/logout.css">
    <link rel="stylesheet" href="css/theme.css">
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

<div class="container">
        <h2 class="topic"><b>Profile Update Form</b></h2>
        <h5 class="condition">(Make sure to fill all the required before submitting)</h5>
        <form action="editTeacherProfile.php" method="post" enctype="multipart/form-data">
        <select id="salutation" name="displayingName" required>
                <option selected value="Mr"> Mr. </option>
                <option value="Mrs"> Mrs. </option>
                <option value="Miss"> Miss </option>
            </select><br>

          <label for="Fullname">Name</label><br/>
          <input type="text" id="Firstname" name="Firstname" placeholder="First name" value=<?php echo htmlspecialchars($firstName) ?> required>

          <input type="text" placeholder="Last name" id="Lastname" name="Lastname" value=<?php echo htmlspecialchars($lastName) ?> required><br/>

          <label for="name">User Name</label><br>
          <input type="text" id="name" name="name"  placeholder="Your user name.." value=<?php echo htmlspecialchars($username) ?> required >
      
          <label for="password">Password</label><br/>
          <input type="password" id="password" name="password" placeholder="Enter a password" >

          <input type="password" placeholder="Confirm Password" id="confirm_password" ><br/>

            
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter a valid email.." value=<?php echo htmlspecialchars($email) ?> required>

         
      
          <label for="district">District</label>
          <input type="text" id="district" name="district"  placeholder="Your district.." value=<?php echo htmlspecialchars($district) ?> required>

          <label for="contact">Contact number</label>
          <input type="text" id="contact" name="contact"  placeholder="Your contact number.." value=<?php echo htmlspecialchars($contact_number) ?> required>
      
          <label for="image">Profile Photo:</label>
          <input id="image" type="file" name="image"  ?> 

          <label for="discription">Description</label><br>
          <textarea id="discription" name="discription" placeholder="Enter a discription.." style="height:200px" value=<?php echo htmlspecialchars($description) ?>></textarea><br>

          <button type="submit" name="submit" id="submit_button"  onclick="return Validate()">submit</button>
          <a href="teacherLogin.php"> <button type="button" id="cancel-button" class="cl">cancel</button></a>
        </form>
    </div>
    <script type="text/javascript">

            function Validate() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if(password.length<8) {  
                //document.getElementById("message").innerHTML = "**Password length must be atleast 8 characters"; 
                alert("Passowrd should be atleast 8 characters"); 
                return false;  
            } 
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
            }

      </script>
    
</body>
</html>










