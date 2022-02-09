<?php
include_once("../Private/config/ConnectSingleton.php");
include_once("../Private/classes/User.php");
include_once("../Private/classes/Teacher.php");
include_once("../Private/classes/Ad.php");
include_once("../Private/classes/student.php");
include_once("../Private/classes/FactoryDP/Factory.php");
include_once("../Private/classes/FactoryDP/AdFactory.php");
include_once("../Private/classes/FactoryDP/AdTemp.php");
include_once("../Private/classes/FactoryDP/Product.php");
session_start();

//create connection
$connector = ConnectSingleton::getInstance();
$conn = $connector->getConnection();
?>
<!DOCTYPE html>
<html>

<head>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/advertisement.css">
    <link rel="stylesheet" href="css/theme.css">
    <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/logout.css">

    <title>Advertisements</title>
</head>

<body>
    <!-- navigation bar 
    <div class="topnav">
        <a href="index.php">Home</a>
        <div class="search-container">
            <form action="/action_page.php">
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <a style="float:right" id=id2 href="contactUs.php">Contact us</a>
    </div>-->


    <?php
    $UserValue = $_SESSION['userValue'];

    $logged = false;
    if (isset($_SESSION['obj'])) {
        $logged = true;
        $User = $_SESSION['obj'];
        $name=$User->getUsername();
        
    } else {
        $logged = false;
    }



    $isSearch = false;
    $adIdArray = array();
    if ($UserValue == 0) {
        $allAdsQry = "SELECT Id FROM advertisement";
    } else {
        $userId = $User->getId();
        $allAdsQry = "SELECT Id FROM advertisement WHERE teacher_id = $userId";
    }
    $allAds = mysqli_query($conn, $allAdsQry);
    $factory = new AdFactory();
    $adObjects = array();
    foreach($allAds as $facAdId){
        $test = $facAdId['Id'];
        $ad = $factory->anOperation2($test);
        array_push($adObjects,$ad);
    }

    if (isset($_POST['submit'])) {
        if (!empty($_POST['search'])) {
            $isSearch = true;
            $grade = $_POST['grade'];
            $medium = $_POST['medium'];
            $subject = $_POST['search'];
            if ($UserValue == 0) {
                if ($grade == "All" && $medium == "All") {
                    $cls_qry = "SELECT * FROM class WHERE subject='$subject'";
                } elseif ($grade == "All") {
                    $cls_qry = "SELECT * FROM class WHERE medium = '$medium' AND subject='$subject'";
                } elseif ($medium == "All") {
                    $cls_qry = "SELECT * FROM class WHERE grade = '$grade' AND subject='$subject'";
                } else {
                    $cls_qry = "SELECT * FROM class WHERE grade = '$grade' AND medium = '$medium' AND subject='$subject'";
                }
            } else {
                $userId = $User->getId();
                if ($grade == "All" && $medium == "All") {
                    $cls_qry = "SELECT * FROM class WHERE teacher_id='$userId' AND subject='$subject'";
                } elseif ($grade == "All") {
                    $cls_qry = "SELECT * FROM class WHERE teacher_id='$userId' AND medium = '$medium' AND subject='$subject'";
                } elseif ($medium == "All") {
                    $cls_qry = "SELECT * FROM class WHERE teacher_id='$userId' AND grade = '$grade' AND subject='$subject'";
                } else {
                    $cls_qry = "SELECT * FROM class WHERE teacher_id='$userId' AND grade = '$grade' AND medium = '$medium' AND subject='$subject'";
                }
            }
            $cls_qry = mysqli_query($conn, $cls_qry);
            if (mysqli_num_rows($cls_qry) > 0) {
                $clsIdArray = array();
                foreach ($cls_qry as $cls) {
                    array_push($clsIdArray, $cls['Id']);
                }

                $adToclsQuery = "SELECT * FROM advertisement_class";
                $adToclsQuery = mysqli_query($conn, $adToclsQuery);
                if (mysqli_num_rows($adToclsQuery) > 0) {
                    foreach ($adToclsQuery as $newEntry) {
                        $id = $newEntry['class_id'];
                        if (in_array($id, $clsIdArray)) {
                            array_push($adIdArray, $newEntry['ad_id']);
                        }
                    }
                }
            }
        }
    }
    ?>

    <div class="topnav">
        <a href="index.php">Home</a>

        <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if ($User instanceof Student) { ?>href="dashboard.php" <?php } else { ?>href="teacherDashboard.php" <?php } ?>>Dashboard</a></div>
        <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id3 style="float: right;" onclick="document.getElementById('id01').style.display='block'">Log out</a></div>




        <div id="id01" class="logout">
            <div class="logout_msg animate">
                <div class="top">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                </div>
                <h1>Log Out</h1>
                <p><?php echo  $name; ?> are you sure you want to log out?</p>
                <form action="classCard.php" method="post">
                    <button id="log" type="submit" class="yes" name="logout">Yes</button>
                    <button id="log" type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">No</button>
                </form>


            </div>
        </div>

        <a style="float:right" id=id2 href="contactUs.php">Contact us</a>


        <div class="search-container">
            <form action="" method="POST">
                <label for="grade">Grade:</label>
                <select name="grade" id="grade">
                    <option value="All">All</option>
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
                </select>
                <label for="medium">Medium:</label>
                <select name="medium" id="medium">
                    <option value="All">All</option>
                    <option value="Sinhala">Sinhala</option>
                    <option value="English">English</option>
                    <option value="Tamil">Tamil</option>
                </select>
                <input type="text" placeholder="Search.." name="search">
                <button type="submit" name="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

    </div>

    <?php
    if (sizeof($adObjects) > 0) {
        if ($isSearch && sizeof($adIdArray) == 0) {
    ?><p>No Matching Advertisements...</p><?php
    } else {
        foreach ($adObjects as $currAd) {
            $currId = $currAd->getId();
            if ($isSearch == true) {
                if (in_array($currId, $adIdArray) == false) {
                    continue;
                }
            }
            $ownerId = $currAd->getTeacherId();
            $heading = $currAd->getHeading();
            $description = $currAd->getDescription();
            $background = $currAd->getBackground();
            $background = "../Private/Backgrouns/AdBackgrounds/".$background;

            $ownerDetails = "SELECT * FROM teacher WHERE Id = $ownerId";
            $result = mysqli_query($conn, $ownerDetails);
            $ownerDetailsResult = mysqli_fetch_array($result);

            //$adCls_qry = "SELECT * FROM advertisement_class WHERE ad_id = $currId";
            //$adCls_result = mysqli_query($conn, $adCls_qry);
            $adCls_result=$currAd->getClassArray();
            $emptyWarning = false;
            if(sizeof($adCls_result)<=0){
                if ($UserValue == 0) {
                    continue;
                } else {
                    $emptyWarning = true;
                }
            }


            $fname = $ownerDetailsResult['first_name'];
            $lname = $ownerDetailsResult['last_name'];
            //$image = "ProfilePics/";
            $image = "../Private/uploads/";

            if (!empty($ownerDetailsResult['profile_photo'])) {
                $image .= $ownerDetailsResult['profile_photo'];
            } else {
                $image .= "default.jpg";
            }
            ?>
                <div class="card" style="background-image:url(<?php echo $background?>)">
                    <div class="col1">
                        <img src="<?= $image ?>" alt="profile picture">


                        <h2><?php echo $fname . " " . $lname; ?></h2>
                        
                    </div>
                    <div class="col2">
                        <h1><?php echo $heading; ?></h1>
                        <p class="title"><?php echo $description; ?></p>
                        <ul>
                            <?php
                            if (sizeof($adCls_result) > 0) {
                                foreach ($adCls_result as $clsId) {
                                    //$req_id = $clsId['class_id'];
                                    $cls_qry = "SELECT * FROM class WHERE id = $clsId";
                                    $cls_result = mysqli_query($conn, $cls_qry);
                                    $cls = mysqli_fetch_array($cls_result);
                            ?>
                                    <li class="item"><?php echo "Grade " . $cls['grade'] . " " . $cls['subject'] . " - " . $cls['medium'] . " Medium  "; ?>
                                        <?php if ($UserValue == 0) { ?>
                                            <button onclick="gotoClass('<?php echo $cls['Id'] ?>')" type="button">View Details</button>
                                    </li>
                                <?php
                                         }
                                ?>
                                <br>
                        <?php
                                }
                            }elseif($emptyWarning){
                                ?><p style = "color:red">There are no valid classes to display. Edit the advertisement to add new classes or delete the advertisement.</p><?php
                            }

                        ?>
                        </ul>
                    </div>
                    <?php if ($UserValue == 1) { ?>
                        <button onclick="gotoAd('<?php echo $currId ?>')" type="button">View Advertisement</button>
                    <?php } ?>
                </div>


    <?php
            }
         }
    }
     $conn->close();
    ?>


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
        function gotoClass(clsId) {
            //alert(clsId);
            window.location = "adToclzProxy.php?clsId=" + clsId;
        }

        function gotoAd(adId) {
            window.location = "adToTestFactory.php?adId=" + adId;
        }
    </script>

</body>

</html>