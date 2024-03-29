<?php
    include_once("../Private/config/ConnectSingleton.php");
    include_once("../Private/classes/User.php");
    include_once("../Private/classes/Teacher.php");
    include_once("../Private/classes/FactoryDP/Factory.php");
    include_once("../Private/classes/FactoryDP/AdFactory.php");
    include_once("../Private/classes/FactoryDP/AdTemp.php");
    include_once("../Private/classes/FactoryDP/Product.php");
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

    $teacher = $_SESSION['obj'];
    $tcrId = $teacher->getId();
    $ad_id = $_GET['adId'];

    $connector = ConnectSingleton::getInstance();
    $conn = $connector->getConnection();

    $sql = "SELECT * FROM advertisement WHERE Id = $ad_id";
    $sql = mysqli_query($conn,$sql);
    if(mysqli_num_rows($sql)<=0){
        header("Location: adCollectionWithFactory.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/advertisement.css">
<link rel="stylesheet" href="css/theme.css">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/logout.css">
<link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">
<title>Edit Advertisment</title>


</head>
<body>
 <!-- navigation bar -->
 <div class="topnav">
            <a href="index.php">Home</a>
            <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if ($student instanceof Student) { ?>href="dashboard.php" <?php } else { ?>href="teacherDashboard.php" <?php } ?>>Dashboard</a></div>
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
        $teacherqry = "SELECT * FROM teacher WHERE Id = $tcrId";
        $result =mysqli_query($conn,$teacherqry);
        $row = mysqli_fetch_array($result);
        $fname = $row['first_name'];
        $lname = $row['last_name'];
        $image = "../Private/uploads/";

        if(!empty($row['profile_photo'])){
            $image.=$row['profile_photo'];
            
        }
        else{
            $image.="default.jpg";
        }
        //$image = "ProfilePics/".$row['profile_photo'];
        //echo $image;

        //$ad_id=2; //hardcoded
        //$ad_id = $_SESSION['adid'];

        //$ad_qry= "SELECT * FROM advertisement WHERE id = $ad_id";
        //$ad_result=mysqli_query($conn,$ad_qry);
        //$adRow=mysqli_fetch_array($ad_result);
        $factory = new AdFactory();
        $ad = $factory->anOperation2($ad_id);
        

        //$heading = $adRow['heading'];
        //$description = $adRow['description'];
        //$background = "AdBackgrounds/".$adRow['background'];
        $heading = $ad->getHeading();
        $description = $ad->getDescription();
        $background = $ad->getBackground();
        $background = "../Private/Backgrouns/AdBackgrounds/".$background;


        $adCls_qry="SELECT * FROM advertisement_class WHERE ad_id = $ad_id";
        $adCls_result=mysqli_query($conn,$adCls_qry);

        
    ?>

<div class="card" style="background-image:url(<?php echo $background?>)">
    <div class="col1">
        <img src="<?=$image?>" alt="profile picture">
        
        
        <h2><?php echo $fname." ".$lname; ?></h2>
    </div>
    <div class="col2">
        <h1><?php echo $heading; ?></h1>
        <p class="title"><?php echo $description; ?></p>
        <ul>
            <?php
            if(mysqli_num_rows($adCls_result)>0){
                foreach($adCls_result as $clsId){
                    $req_id = $clsId['class_id'];
                    $cls_qry="SELECT * FROM class WHERE id = $req_id";
                    $cls_result=mysqli_query($conn,$cls_qry);
                    $cls=mysqli_fetch_array($cls_result);
                    ?>
                    <li class="item"><?php echo "Grade ".$cls['grade']." ".$cls['subject']." - ".$cls['medium']." Medium  "; ?></li>
                    <br>
                    <?php
                }
            }
            ?>
        </ul>    
        <form action="adForm.php" method="POST">
            <!--<input type="submit" name="submit" value="Edit">-->
            <input type="hidden" id="custId" name="custId" value=<?=$ad_id?>>
            <button name = "submit" value = "submit" >Edit</button><br><br>
        </form>  
        <form action="" method="POST" onsubmit = "return deleteAd();">
            <!--<input type="submit" name="submit" value="Delete">-->
            <button style = "background-color:red"name = "submit" value = "submit">Delete</button> <br> 
        </form>
    </div>
    

</div>

<!-- footer -->
<!-- <div class="footer"> -->
        <!-- <h2>Footer</h2> -->
    <!-- </div> -->

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
        //redirecting to classproxy
        function deleteAd(){
            if (confirm("Are you sure you want to delete this ad?") == false) {
                    return false;
            } else {
                   return true;
            }
        }
    </script>

</body>
</html>
<?php
if(isset($_POST['submit'])){

    $query="DELETE FROM advertisement_class WHERE ad_id=$ad_id";
    $queryRun=mysqli_query($conn,$query);
    $query="DELETE FROM advertisement WHERE Id=$ad_id";
    $queryRun2=mysqli_query($conn,$query);

    if ($queryRun === TRUE && $queryRun2 == TRUE) {
        header("Location: adcollectionWithFactory.php");
    }else {
        echo "Error: " . $queryRun . "<br>" . $conn->error;
    }
}
$conn->close();

?>