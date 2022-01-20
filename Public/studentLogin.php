<?php

include_once("../Private/classes/User.php");
include_once("../Private/classes/student.php");
include_once("../Private/classes/uploader.php");
include_once("../Private/classes/connector.php");
include_once("../Private/classes/FactoryDP/studentFactory.php");
include_once("../Private/classes/FactoryDP/Factory.php");



session_start();

if (isset($_POST['loginbtn'])) {

  $username = $_POST['uname'];
  $password = $_POST['psw'];
  $encrypted_password = md5($password);

  // $connector=new Connector();
  // $connec=$connector->connectDatabase();

  // $query="select * from student WHERE Username='$username' AND Passkey='$encrypted_password'";
  // $query_run=mysqli_query($connec,$query);
  // $row = $query_run->fetch_array();
  // if(is_array($row)){

  //   //valid
  //   $id=$row['id'];
  //   $firstName=$row['First_name'];
  //   $lastName=$row['Last_name'];
  //   $email=$row['email'];
  //   $grade=$row['grade'];
  //   $district=$row['District'];
  //   $profilePhoto="uploads/".$row['profile_photo'];
  //   if ($profilePhoto=="uploads/"){
  //     $profilePhoto = 'uploads/default.jpg';
  // }


  //   $student=Student::getInstance($id,$firstName,$lastName,$username,$password,$email,$district);
  //   //$student=new Student($id,$firstName,$lastName,$username,$encrypted_password,$email,$district);
  //   $student->setGrade($grade);
  //   $student->setProfPhoto($profilePhoto);
  //   $student->setId($id);
  //   $student->setProfPhoto($profilePhoto);
  $StudentFactory = new StudentFactory();
  $student = $StudentFactory->anOperation($username, $encrypted_password);
  //echo $student->getFirstname();

  $_SESSION['obj'] = $student;
  $_SESSION['userValue'] = 0;


  header('location:dashboard.php');
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

  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/studentLogin.css">
  <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">

  <title>StudentLogin</title>
</head>

<body>
  <!-- navigation bar -->
  <div class="topnav">
    <a href="index.php">Home</a>
    <a style="float:right" id=id2 href="contactUs.php">Contact us</a>
  </div>

  <!-- Form for student login -->
  <div class="header">
    <form class="modal-content animate" action="studentLogin.php" method="post">
      <div class="imgcontainer">
        <img src="../Private/Images/StudentLogin.png" alt="Avatar" class="avatar">
      </div>
      <div class="container">
        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>

        <!-- <input type="submit" id="login" name="loginbtn" value="Login"/><br> -->
        <button type="submit" id="login" name="loginbtn">Login</button>
        <label>
          <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>
      </div>
      <div class="container">
        <a href="index.php"><button type="button" class="cancelbtn" name="cancelbtn">Cancel</button></a>
        <span class="signin">New user? <a href="studentForm.php">Create account</a></span>
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