    <?php
    include_once("../Private/classes/User.php");
    include_once("../Private/classes/Teacher.php");
    include_once("../Private/classes/uploader.php");
    //include_once("classes/connector.php");
    include_once("../Private/config/ConnectSingleton.php");
    include_once("../Private/classes/Ad.php");
    session_start();

    $logged = false;
    if (isset($_SESSION['obj'])) {
        $logged = true;
        $teacher = $_SESSION['obj'];
        $teacher_id = $teacher->getId();
        $name=$teacher->getUsername();
    } else {
        $logged = false;
    }


    //create connection
   // $connector = new Connector();
   // $conn = $connector->connectDatabase();
   $connector = ConnectSingleton::getInstance();
   $conn = $connector->getConnection();

    $ad = new Ad(null, null, null);
    $isUpdate = false;
    $toUpdate = null;

    if (isset($_POST['submit'])) {
        $isUpdate = true;
        $toUpdate = $_POST['custId'];
        $qry = "SELECT * FROM advertisement WHERE Id=$toUpdate";
        $qryRun = mysqli_query($conn, $qry);
        $qry = mysqli_fetch_array($qryRun);

        $ad = new Ad($qry['teacher_id'], $qry['heading'], $qry['description']);
    }
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
        <title>Student request form</title>
        <link rel="stylesheet" href="css/adForm.css">
        <link rel="stylesheet" href="css/theme.css">
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/logout.css">
        <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">

        <script type="text/javascript" src="js/adForm.js"></script>
    </head>

    <body>
        <!-- navigation bar -->
        <div class="topnav">
            <a href="index.php">Home</a>
            <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if($teacher instanceof Student){?>href="dashboard.php"<?php }else{?>href="teacherDashboard.php"<?php }?>>Dashboard</a></div>
            <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id3 style="float: right;" onclick="document.getElementById('id01').style.display='block'">Log out</a></div>




            <div id="id01" class="logout">
                <div class="logout_msg animate">
                    <div class="top">
                        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </div>
                    <h1>Log Out</h1>
                    <p><?php echo $name ?> are you sure you want to log out?</p>
                    <form action="classCard.php" method="post">
                        <button id="log" type="submit" class="yes" name="logout">Yes</button>
                        <button id="log" type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">No</button>
                    </form>


                </div>
            </div>

            <a style="float:right" id=id2 href="contactUs.php">Contact us</a>
        </div>
        
        <div class="container">
            <h1>Fill Advertisement Details</h1>
            <h5>(Make sure to fill all the required fields before submitting)</h5>
            <form name="adForm" action="actionAdForm.php" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">

                <div class="toBeFilled">
                    <label for="heading">Add Heading</label>
                </div><br>
                <textarea id="heading" name="heading" placeholder="Type a heading for your advertisement.." required><?php echo $ad->getHeading(); ?></textarea>
                <br>

                <div class="toBeFilled">
                    <label for="description">Add description</label>
                </div>
                <textarea id="description" name="description" placeholder="Type a description about your classes.." required><?php echo $ad->getDescription(); ?></textarea><br>

                <div class="toBeFilled">
                    <label for="heading">Select Classes to Advertise</label>
                </div><br>

                <div class="boxes">
                    <?php
                    $class_query = "SELECT * FROM class WHERE teacher_id = $teacher_id";
                    $query_run = mysqli_query($conn, $class_query);
                    $checkBoxNo = 0;

                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $class) {
                            $checkBoxNo += 1
                    ?>
                            <input type="checkbox" name="classlist[]" id="<?= $checkBoxNo ?>" value="<?= $class['Id']; ?>" /> <?= $class['subject'] . "- Grade " . $class['grade'] . " - " . $class['day']; ?> <br />
                    <?php
                        }
                    } else {
                        echo "No Record Found";
                    }
                    $conn->close()
                    ?>
                </div>

                <br>
                <hr> <br>
                <input type="hidden" id="checkBoxCount" name="checkBoxCount" value=<?= $checkBoxNo ?>>
                <div class="row">
                    <?php
                    if ($isUpdate) {
                    ?>
                        <input type="hidden" id="adid" name="adid" value=<?= $toUpdate ?>>
                        <input type="submit" name="submit" id="<?= $checkBoxNo ?>" value="Update">
                        <button type="reset" value="Reset">Cancel</button>
                        <?php
                    } else {
                        ?>
                        <input type="submit" name="submit" id="<?= $checkBoxNo ?>" value="Submit">
                        <button type="reset" value="Reset">Reset</button>
                    <?php
                                                                                                }
                    ?>


                </div>
            </form>
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
        </script>
    </body>

    </html>