<?php
    include_once("classes/connector.php");
    include_once("classes/Request.php");
    include_once("classes/State/State.php");
    include_once("classes/State/Requested.php");
    include_once("classes/User.php");
    include_once("classes/student.php");
    session_start();
    
    $clsId = $_GET['clsId'];

    $connector = new Connector();
    $conn = $connector->connectDatabase();

    if (isset($_SESSION['obj'])) {

        $logged = true;
        $student = $_SESSION['obj'];
        $name=$student->getUsername();
    } else {
        $logged = false;
    }

    $clsqry = "SELECT * FROM class WHERE Id = $clsId";
    $result = mysqli_query($conn, $clsqry);
    $classDetails = mysqli_fetch_array($result);

    $tcrId = $classDetails['teacher_id'];
    $teacherqry = "SELECT * FROM teacher WHERE Id =$tcrId";
    $result = mysqli_query($conn, $teacherqry);
    $teacherDetails = mysqli_fetch_array($result);

    $curr_capacity = $classDetails['current_capacity'];
    $capacity = $classDetails['capacity'];

?>
<html>
    <head>  
        <link rel="stylesheet" href="adToClzProxy.css">
        <link rel="stylesheet" href="theme.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="icon" type="image/x-icon" href="Images/icon.png">
    <link rel="stylesheet" href="logout.css">
    <title>Request</title>
    </head>
    <body>
         <!-- navigation bar -->
    <div class="topnav">
        <a id=id1 href="index.php">Home</a>
        <div id="idlg" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id3 style="float: right;" onclick="document.getElementById('id01').style.display='block'">Log out</a></div>
        <div id="id02" <?php if ($logged == false) { ?>style="display:none" <?php } ?>><a id=id1 <?php if ($student instanceof Student) { ?>href="dashboard.php" <?php } else { ?>href="teacherDashboard.php" <?php } ?>>Dashboard</a></div>




        <div id="id01" class="logout">
            <div class="logout_msg animate">
                <div class="top">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                </div>
                <h1>Log Out</h1>
                <p><?php echo $name ?> are you sure you want to log out?</p>
                <!-- <p>Are you sure you want to Log out?</p> -->
                <!-- <input type="button" class="yes" name="logout"  value="Yes"> -->
                <form action="dashboard.php" method="post">
                    <button id="log" type="submit" class="yes" name="logout">Yes</button>
                    <button id="log" type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">No</button>
                </form>


            </div>
        </div>

        <a style="float:right" id=id2 href="contactUs.php">Contact us</a>


    </div>

        <form action="" method="POST" onsubmit="return request();">
            <div class = "card">
                <h1><?php echo $classDetails['subject']?></h1>
                <h2>by</h2>
                <h1><?php echo $teacherDetails['designation']." ".$teacherDetails['first_name']." ".$teacherDetails['last_name']?></h1>
                <div class = details>
                    <p>Venue: <?php echo $classDetails['location']?></p>
                    <p>Time: <?php echo "from ". $classDetails['starttime']." to ".$classDetails['endtime']?></p>
                    <p>For: <?php echo "Grade ".$classDetails['grade']." students"?></p>
                    <p>Medium: <?php echo $classDetails['medium']?></p>
                    <p>Fees: <?php echo "Rs:".$classDetails['fee']."/="?></p>
                    <p>For additional details, please contact the teacher via :<?php echo $teacherDetails['contact_number']?> </p>
                </div>
                <!--<button onclick="request()">Request</button>-->
                <?php
                if($curr_capacity>=$capacity || getReqStatus($conn,$student->getId(),$clsId) || getClsStatus($conn,$student->getId(),$clsId)){
                    ?><input type="submit" name="submit" value="Request" disabled><?php
                    if(getReqStatus($conn,$student->getId(),$clsId)){
                    ?><p style="color:red;">Request already sent</p><?php
                    }elseif(getClsStatus($conn,$student->getId(),$clsId)){
                        ?><p style="color:red;">Already enrolled</p><?php
                    }elseif($curr_capacity>=$capacity){
                        ?><p style="color:red;">Capacity exceeded</p><?php
                    }
                }else{
                    ?><input type="submit" name="submit" value="Request"><?php
                }
                ?>
                <br><br>
                
            </div>
        
        </form>



        <script>
            function request() {
                //let text = "Are you sure you want to join to this class?";
                if (confirm("Are you sure you want to join to this class?") == false) {
                    return false;
                } else {
                   return true;
                }

            }
        </script>
</body>

</html>
<?php
if (isset($_POST['submit'])) {

    $student_id = $student->getId();

    $requestObj = new Request($clsId, $student_id, $tcrId);
    $objState = $requestObj->getState();

    $query = "INSERT INTO request (student_id,class_id,teacher_id,state) VALUES ('$student_id','$clsId','$tcrId','$objState')";
    $queryRun = mysqli_query($conn, $query);

    if ($queryRun === TRUE) {
         // send notification
        $last_id = mysqli_insert_id($conn); 
        $msg = "New enroll Request";
        $date = date('y.m.d h:m:s');
        $sql_insert = mysqli_query($conn, "INSERT INTO notification(message,cr_date,class_id,sender,receiver,request_id) VALUES('$msg','$date','$clsId','$student_id','$tcrId','$last_id')");
        if ($sql_insert) {
            echo "<script>alert('message sent');</script>";
        } else {
            echo mysqli_error($con);
        }
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $queryRun . "<br>" . $conn->error;
    }
}
$conn->close();
function getReqStatus($conn,$student_id,$clsId){
    $state = "Requested";
    $studentState = false;
    $sql = "SELECT * FROM request WHERE student_id='$student_id' AND state='$state'";
    $sql = mysqli_query($conn,$sql);
    $reqList = array();
    if(mysqli_num_rows($sql)>0){
        foreach($sql as $req){
            if($req['class_id']==$clsId){
                $studentState = true;
                break;
            }
        }
    }
    return $studentState;
}
function getClsStatus($conn,$student_id,$clsId){
    $sql = "SELECT * FROM student_class WHERE class_id = '$clsId' AND student_id = '$student_id'";
    $sql = mysqli_query($conn,$sql);
    if(mysqli_num_rows($sql)>0){
        return true;
    }else{
        return false;
    }
}
?>