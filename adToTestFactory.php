<?php
    include_once("classes/connector.php");
    include_once("classes/User.php");
    include_once("classes/Teacher.php");
    include_once("classes/FactoryDP/Factory.php");
    include_once("classes/FactoryDP/AdFactory.php");
    include_once("classes/FactoryDP/AdTemp.php");
    include_once("classes/FactoryDP/Product.php");
    session_start();

    $teacher = $_SESSION['obj'];
    $tcrId = $teacher->getId();
    $ad_id = $_GET['adId'];

    $connector = new Connector();
    $conn = $connector->connectDatabase();

   // $sql = "SELECT * FROM advertisement WHERE Id = $ad_id";
    //$sql = mysqli_query($conn,$sql);
    //if(mysqli_num_rows($sql)<=0){
       // header("Location: adcollection.php");
   // }
?>
<!DOCTYPE html>
<html>
    <head>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="advertisement.css">
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

    <?php
        $teacherqry = "SELECT * FROM teacher WHERE Id = $tcrId";
        $result =mysqli_query($conn,$teacherqry);
        $row = mysqli_fetch_array($result);
        $fname = $row['first_name'];
        $lname = $row['last_name'];
        $image = "uploads/";

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
        $background = "AdBackgrounds/".$background;


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
        header("Location: adcollection.php");
    }else {
        echo "Error: " . $queryRun . "<br>" . $conn->error;
    }
}
$conn->close();

?>