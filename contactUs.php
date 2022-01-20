<?php
include_once("classes/User.php");
include_once("classes/student.php");
include_once("classes/Teacher.php");
include_once("classes/connector.php");
session_start();
$connector = new Connector();
$con = $connector->connectDatabase();

$logged = false;
if (isset($_SESSION['obj'])) {
    $logged = true;
    $student = $_SESSION['obj'];

    $id = $student->getId();
    $name = $student->getUsername();
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    
    <link rel="stylesheet" href="contactUs.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="logout.css">
    <link rel="icon" type="image/x-icon" href="Images/icon.png">
    <title>ContactUs</title>
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

    <div class="block1">
        <div class="card">
            <div class="imgcontainer">
                <img src="Images/madara.jpg">
            </div>
            <div class="container">
              <h4><b>Madara Semini</b></h4>
              <p>Computer Science Engineering(UG)</p>
              <p>University of Moratuwa</p>
              <p><i class="fa fa-envelope"></i> Email: madara.19@cse.mrt.ac.lk</p>
              <p><i class="fa fa-phone"></i> Phone: +94714659756</p>
            </div>
          </div>
    
    
          <div class="card">
            <img src="Images/saku.jpg">
            <div class="container">
              <h4><b>Sakuni Bandara</b></h4>
              <p>Computer Science Engineering(UG)</p>
              <p>University of Moratuwa</p>
              <p><i class="fa fa-envelope"></i> Email: bandaratbsh.19@uom.lk</p>
              <p><i class="fa fa-phone"></i> Phone: +94702306534</p>
            </div>
          </div>
    </div>
    


    <div class="block2">
        <div class="card">
            <img src="Images/jimmi.jpg" >
            <div class="container">
              <h4><b>Jithmi Ranasighe</b></h4>
              <p>Computer Science Engineering(UG)</p>
              <p>University of Moratuwa</p>
              <p><i class="fa fa-envelope"></i> Email: ranasingheradjn.19@uom.lk</p>
              <p><i class="fa fa-phone"></i> Phone: +94762878555</p>
            </div>
          </div>
    
    
          <div class="card">
            <img src="Images/satha.jpg" >
            <div class="container">
              <h4><b>Sathsarani Kapukotuwa</b></h4>
              <p>Computer Science Engineering(UG)</p>
              <p>University of Moratuwa</p>
              <p><i class="fa fa-envelope"></i> Email: kapukotuwapbksn.19@uom.lk</p>
              <p><i class="fa fa-phone"></i> Phone: +94770623837</p>
            </div>
          </div>
    </div>
    
    <div class="footer">
        <h2>Footer</h2>
    </div>
    
</body>
</html>