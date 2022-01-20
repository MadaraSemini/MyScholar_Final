<?php
include_once("classes/User.php");
include_once("classes/Teacher.php");  
include_once("classes/uploader.php");
include_once("classes/connector.php");
include_once("classes/FactoryDP/teacherFactory.php");
include_once("classes/FactoryDP/Factory.php");


    session_start();
   
    
    if(isset($_POST['loginbtn'])){

      $username=$_POST['uname'];
      $password=$_POST['psw'];
      $encrypted_password=md5($password);

  //     $connector=new Connector();
  // $connec=$connector->connectDatabase();

  //     $query="select * from teacher WHERE Username='$username' AND Passkey='$encrypted_password'";
  //     $query_run=mysqli_query($connec,$query);
  //     $row = $query_run->fetch_array();
  // if(is_array($row)){

  //       //valid
  //       $id=$row['Id'];
  //       $firstName=$row['first_name'];
  //       $lastName=$row['last_name'];
  //       $email=$row['email'];
  //       $district=$row['District'];
  //       $designation=$row['designation'];
  //       $description=$row['description'];
  //       $contact=$row['contact_number'];
  //       $profilePhoto="uploads/".$row['profile_photo'];
    
    
  //       $teacher=Teacher::getInstance($id,$firstName,$lastName,$username,$encrypted_password,$email,$district,$designation,$description,$contact);
  //       //$student=new Student($id,$firstName,$lastName,$username,$encrypted_password,$email,$district);
  //       $teacher->setProfPhoto($profilePhoto);
  //       $teacher->setId($id);
        $teacherFactory= new TeacherFactory($username,$encrypted_password);
        $teacher=$teacherFactory->anOperation($username,$encrypted_password);
    
        $_SESSION['obj']=$teacher;
        $_SESSION['userValue'] = 1;
       header('location:teacherDashboard.php');

      }
      
      
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

    <link rel="stylesheet" href="theme.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="teacherLogin.css">
    <link rel="icon" type="image/x-icon" href="Images/icon.png">

    <title>TeacherLogin</title>
</head>
<body>

<!-- navigation bar -->
<div class="topnav">
  <a href="index.php">Home</a>
  <a style="float:right" id=id2 href="contactUs.php">Contact us</a>
</div>

<!-- Form for teacher login -->
<div class="header">
      
      <form class="modal-content animate" action="teacherLogin.php" method="post">
          <div class="imgcontainer">
              <!-- <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span> -->
              <img src="Images/TeacherLogin.png" alt="Avatar" class="avatar">
          </div>
        
          <div class="container">
              <label for="uname"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="uname" required>
        
              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="psw" required>
                
              <!-- <input type="submit" id="login" name="loginbtn" value="Login"/><br> -->
              <button type="submit" id="login" name="loginbtn" >Login</button>
              <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
              </label>
          </div>
        
          <div class="container" style="background-color:#f1f1f1">
              <a href="index.php"> <button type="button" class="cancelbtn">Cancel</button></a>
              <span class="signin">New user?  <a href="teacherForm.php">Create account</a></span>
          </div>
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

</body>
</html>