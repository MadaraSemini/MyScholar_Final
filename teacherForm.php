<?php
 
    include_once("classes/User.php");
    include_once("classes/Teacher.php");
    include_once("classes/connector.php");
    include_once("classes/uploader.php");

    if(isset($_POST["submit"])){

        if(!empty($_POST["Firstname"])&& !empty($_POST["Lastname"]) && !empty($_POST["name"])  && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["district"]) && !empty($_POST["contact"])){
            $first_name=$_POST["Firstname"];
            $last_name=$_POST["Lastname"];
            $username=$_POST["name"];
            $password=$_POST["password"];
            $encrypted_password=md5($password);
            $email=$_POST["email"];
            $district=$_POST["district"];
            $contact=$_POST["contact"];
            $description=$_POST["discription"];
            $designation=$_POST['displayingName'];


            $prof_photo;

            //$teacher=new Teacher($first_name,$last_name,$username,$encrypted_password,$email,$district,$designation,$description,$contact);

            //$student=new Student($firt_name,$last_name,$username,$password,$email,$district);

            

            
            $filename = $_FILES["image"]["name"];
            $tempname = $_FILES["image"]["tmp_name"];
            $folder = "uploads/".$filename;    

            $file_uploader=new Uploader($filename,$tempname,$folder);

            $folder = "ProfilePics/".$filename;

            $connector=new Connector();
            $connec=$connector->connectDatabase();


            /*$connec=mysqli_connect("localhost","root","","myscholar");
            if(!$connec){
                echo("connection error".mysqli_connect_error()."<br/>");
             die();
            }else{

            }*/
            




        

            $first_name=mysqli_real_escape_string($connec,"$first_name");
            $last_name=mysqli_real_escape_string($connec,"$last_name");
            $username=mysqli_real_escape_string($connec,"$username");
            $password=mysqli_real_escape_string($connec,"$password");
            $email=mysqli_real_escape_string($connec,"$email");
            $district=mysqli_real_escape_string($connec,"$district");
            $filename=mysqli_real_escape_string($connec,"$filename");
            $contact=mysqli_real_escape_string($connec,"$contact");
            $description=mysqli_real_escape_string($connec,"$description");
            $designation=mysqli_real_escape_string($connec,"$designation");






            $sql="INSERT INTO teacher(designation,first_name, last_name, Username, passkey, email, District, profile_photo,contact_number,description) VALUES('$designation','$first_name','$last_name','$username', '$encrypted_password', '$email', '$district', '$filename', '$contact' ,'$description');";

            $file_uploader->uploadImage();

            if (move_uploaded_file($tempname, $folder))  {
                $msg = "Image uploaded successfully";
            }else{
                $msg = "Failed to upload image";
            }


            if(mysqli_query($connec,$sql)){
                echo "<script> alert('Registration Successfull. Go to the login page.');</script>";
                header('location:teacherLogin.php');
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
    <title>Teacher register form</title>
    <link rel="stylesheet" href="teacherForm.css">
    <link rel="stylesheet" href="theme.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="icon" type="image/x-icon" href="Images/icon.png">

</head>
<body>
<!-- navigation bar -->
<div class="topnav">
        <a href="index.php">Home</a>
        <a style="float:right" id=id2 href="contactUs.php">Contact us</a>
    </div>

<!-- registration form -->
    <div class="container">
        <h2 class="topic"><b>Teacher Register Form</b></h2>
        <h5 class="condition">(Make sure to fill all the required before submitting)</h5>
        <form action="teacherForm.php" method="post" enctype="multipart/form-data">
        <select id="salutation" name="displayingName" required>
                <option selected value="Mr"> Mr. </option>
                <option value="Mrs"> Mrs. </option>
                <option value="Miss"> Miss </option>
            </select><br>

          <label for="Fullname">Name</label><br/>
          <input type="text" id="Firstname" name="Firstname" placeholder="First name" required>

          <input type="text" placeholder="Last name" id="Lastname" name="Lastname" required><br/>

          <label for="name">User Name</label><br>
          <input type="text" id="name" name="name"  placeholder="Your user name.." required >
      
          <label for="password">Password</label><br/>
          <input type="password" id="password" name="password" placeholder="Enter a password" required>

          <input type="password" placeholder="Confirm Password" id="confirm_password" required><br/>

            
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter a valid email.." required>

         
      
          <label for="district">District</label>
          <input type="text" id="district" name="district"  placeholder="Your district.." required>

          <label for="contact">Contact number</label>
          <input type="text" id="contact" name="contact"  placeholder="Your contact number.." required>
      
          <label for="image">Profile Photo:</label>
          <input id="image" type="file" name="image"  required>

          <label for="discription">Description</label><br>
          <textarea id="discription" name="discription" placeholder="Enter a discription.." style="height:200px"></textarea><br>

          <button type="submit" name="submit" id="submit_button">submit</button>
          <a href="teacherLogin.php"> <button type="button" id="cancel-button" class="cl">cancel</button></a>
        </form>
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
     
<!-- validation -->
    <script src="teacherForm.js"></script>
    <!-- <script type="text/javascript">

            function Validate() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
            } -->

      </script>
</body>
</html>