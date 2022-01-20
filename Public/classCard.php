<?php
include_once("../Private/config/ConnectSingleton.php");
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:index.php');
}


mysqli_close($con)

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/classCard.css">
    <link rel="icon" type="image/x-icon" href="../Private/Images/icon.png">
    <link rel="stylesheet" href="css/logout.css">

    <title>Class</title>
</head>

<body>
    <!-- navigation bar -->
    <div class="topnav">
        <a id=id1 href="index.php">Home</a>

        <a id=id3 style="float: right;" onclick="document.getElementById('id01').style.display='block'">Log out</a>
        <!--want to modify as abutton -->

        <div id="id01" class="logout">
            <div class="logout_msg animate">
                <div class="top">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                </div>
                <h1>Log Out</h1>
                <p><?php echo $_SESSION['username'] ?> are you sure you want to log out?</p>
                <!-- <input type="button" class="yes" name="logout"  value="Yes"> -->
                <form action="classCard.php" method="post">
                    <button id="log" type="submit" class="yes" name="logout">Yes</button>
                    <button id="log" type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">No</button>
                </form>


            </div>
        </div>
        <a style="float:right" id=id2 href="contactUs.php">Contact us</a>

    </div>


    <!-- class card -->
    <div class="card">
        <div class="title">
            <h1>Class grade</h1>
            <h2>subject</h2>
        </div>
        <div class="content">
            <div class="teacher">
                <img src="" alt="">
                <p>Name:</p>
                <p>Contact No:</p>
                <input type="button" value="View more">
            </div>
            <div class="cls_inf">
                <dl>
                    <dt>Medium:</dt>
                    <dd>Sinhala</dd>
                    <dt>Day</dt>
                    <dd>Monday</dd>
                    <dt>Class Time:</dt>
                    <dd>Start time:End time: </dd>
                    <dt>Class type:</dt>
                    <dd>Hall</dd>
                    <dt>Class Fee:</dt>
                    <dd>Rs.1000</dd>
                    <dt>Location:</dt>
                    <dd>Sipwin Kurunegala</dd>
                    <dt>Description:</dt>
                    <dd>bla bla bla</dd>
                </dl>

            </div>
        </div>

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