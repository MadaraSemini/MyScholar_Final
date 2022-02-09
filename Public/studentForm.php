<?php
    include_once("../Private/classes/User.php");
    include_once("../Private/classes/student.php");  
    //include_once("classes/composite.php");
    include_once("../Private/classes/uploader.php");
    include_once("../Private/config/ConnectSingleton.php");


    if(isset($_POST["submit"])){
        if(!empty($_POST["Firstname"])&& !empty($_POST["Lastname"]) && !empty($_POST["name"])  && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["district"])){
            
            
            $first_name=$_POST["Firstname"];
            $last_name=$_POST["Lastname"];
            $username=$_POST["name"];
            $password=$_POST["password"];
            $encrypted_password=md5($password);
            $email=$_POST["email"];
            $district=$_POST["district"];
            $grade;
            $prof_photo;

            //$student=new Student($first_name,$last_name,$username,$encrypted_password,$email,$district);
            //Create only when the data is in the database

            

            //$student=new Student($firt_name,$last_name,$username,$password,$email,$district);

            if(!empty($_POST["grade"])){
                $grade=$_POST["grade"];
                //$student->setGrade($grade);
            }else{
                $grade=null;
            }
            

            $filename = $_FILES["image"]["name"];
            $tempname = $_FILES["image"]["tmp_name"];
            $folder = "../Private/uploads/".$filename; 

            $file_uploader=new Uploader($filename,$tempname,$folder);
            
               
            //$folder = "uploads/".$filename;
                      


            $connector = ConnectSingleton::getInstance();
            $connec = $connector->getConnection();
           
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
            $grade=mysqli_real_escape_string($connec,"$grade");
            $district=mysqli_real_escape_string($connec,"$district");
            $filename=mysqli_real_escape_string($connec,"$filename");




            $sql="INSERT INTO student(First_name, Last_name, Username, passkey, email, grade, District, profile_photo) VALUES('$first_name','$last_name','$username', '$encrypted_password', '$email', '$grade', '$district', '$filename');";

            $file_uploader->uploadImage();

            /*if (move_uploaded_file($tempname, $folder))  {
                $msg = "Image uploaded successfully";
            }else{
                $msg = "Failed to upload image";
            }*/


            if(mysqli_query($connec,$sql)){
                echo("successfull");
                header("Location: studentLogin.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <title>Student register form</title>
    <link rel="stylesheet" href="css/studentForm.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../Private//Images/icon.png">
</head>
<body>
<!-- navigation bar -->
<div class="topnav">
        <a href="index.php">Home</a>
        <a style="float:right" id=id2 href="contactUs.php">Contact us</a>
    </div>

<!-- registration form -->
    <div class="container">
        <h2 class="topic"><b>Student Register Form</b></h2>
        <h5 class="condition">(Make sure to fill all the required before submitting)</h6>
        <form id="rForm" action="studentForm.php" method="post" enctype="multipart/form-data">

          <label for="Fullname">Name</label><br/>
          <input type="text" id="Firstname" name="Firstname" placeholder="First name" required>

          <input type="text" name="Lastname" placeholder="Last name" id="Lastname" required><br/>
      
          <label for="name">User Name</label>
          <input type="text" id="name" name="name"  placeholder="Your user name.." required >
      
          <label for="password">Password</label><br/>
          <input type="password" id="password" name="password" placeholder="Enter a password" required>

          <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required><br/>


          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter a valid email.." required>

          
      
          <label for="grade">Grade</label><br>
          <select id="grade" name="grade" required>
            
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
          <input type="text" id="district" name="district"  placeholder="Your district.." required>
      
          <label for="image">Profile Photo:</label>
          <input id="image" type="file" name="image">


          <button type="submit" id="submit_button" name="submit"  onclick="return Validate()">submit</button>
          <a href="teacherLogin.php"> <button type="button" id="cancel-button" class="cl">cancel</button></a>
          <!-- <button type="cancel" id="cancel-button" class="cl">cancel</button> -->

        </form>
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
     
<!-- validation -->     
      <script src="js/studentForm.js"></script>
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