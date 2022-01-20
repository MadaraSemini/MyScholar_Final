<?php

    include_once("classes/connector.php");
    //include_once("classes/User.php");
    include_once("classes/Teacher.php");
    include_once("classes/rating.php");

    session_start();
    $connector=new Connector();
    $connec=$connector->connectDatabase();
    $logged = false;
    if (isset($_SESSION['obj'])) {
    $logged = true;
    $student = $_SESSION['obj'];

    $name = $student->getUsername();
    } else {
        $logged = false;
    }

    // $id = $_GET['id'];

    $sql="SELECT * FROM teacher;";
    $result= mysqli_query($connec,$sql);
    $posts=mysqli_fetch_all($result, MYSQLI_ASSOC);
    $teacher = $_SESSION['obj'];

    $id = $teacher->getId();
    $username=$teacher->getUsername();
    $designation=$teacher->getDesignation();
    $firstName=$teacher->getFirstName();
    $lastName=$teacher->getLastName();
    $fullname=$designation.". ".$firstName." ".$lastName;
    $photo_name=$teacher->getProfPhoto();
    $description=$teacher->getDescription();
    $contact_number=$teacher->getContactNumber();
    $district=$teacher->getDistrict();
    $email=$teacher->getEmail();

    if ($photo_name=="uploads/"){
        $photo_name = 'uploads/default.jpg';
    }

    
    $sql2="SELECT * FROM star_rating;";
    $result2= mysqli_query($connec,$sql2);
    $posts2=mysqli_fetch_all($result2, MYSQLI_ASSOC);


    $teacherRatings=array();
    $rating1=0;
    $rating2=0;
    $rating3=0;
    $rating4=0;
    $rating5=0;
    foreach($posts2 as $post):
        
        if ($post["teacher_id"]==$id){
            $rating=new Rating($id);
            $rating->setRating($post["rating"]);
            $teacher->addRatings($rating);
            array_push($teacherRatings,$rating->getRating());

            switch ($rating->getRating()){
                case 1:
                    $rating1++;
                    break;
                case 2:
                    $rating2++;
                    break;
                case 3:
                    $rating3++;
                    break;
                case 4:
                    $rating4++;
                    break;
                case 5:
                    $rating5++;
                    break;
                default:
                    break;
            }
        }
    endforeach;

    $overallRating=($rating1*1+$rating2*2+$rating3*3+$rating4*4+$rating5*5)/count($teacherRatings);
    $teacher->setOverallRating($overallRating);



    $sql3 = "SELECT * FROM class;";
    $result3 = mysqli_query($connec, $sql3);
    $posts3 = mysqli_fetch_all($result3, MYSQLI_ASSOC);

    $enrolled_classes = array();
    foreach ($posts3 as $post3) :
        if ($post3["teacher_id"] == $id) {
            array_push($enrolled_classes, $post3["Id"]);
        }

    endforeach;


    

    mysqli_free_result($result);
    mysqli_free_result($result2);
    mysqli_free_result($result3);

    mysqli_close($connec);


?>




<!-- line 10 dammoth tikk kela wenwa -madara-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
    <title>Teacher Profile</title>
    <link rel="stylesheet" href="teacherProfile.css">
    <link rel="stylesheet" href="theme.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="logout.css">
    <link rel="icon" type="image/x-icon" href="Images/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <div class="card">
        <img src="<?php echo $photo_name ?>" alt="No photo uploaded" name="profile" width="300" height="300"> 
        <div class="details">
            <h1 class="username"><?php echo htmlspecialchars($username) ?></h1><br/>
            <h1 class="fullname" id="fullname"><?php echo htmlspecialchars($fullname)  ?></h1>
            
            <a href="editTeacherProfile.php">Edit profile</a>
        </div>
    </div>

    <div class="desAndRatings">

        <div class="description">
            <h1 class="Des">Description</h1>
            <h2 class="des">Full Name :  <?php echo htmlspecialchars($fullname) ?></h2>
            
            <h2 class="des">Email : <?php echo htmlspecialchars($email) ?></h2>
            
            <h2 class="des">District : <?php echo htmlspecialchars($district) ?></h2>

            <h2 class="des">Myself:</h2>
            <p class="mySelf"><?php echo htmlspecialchars($teacher->getDescription()) ?></p>
        
        </div>

        <div class="ratings">
            
            <h1 class="myRatings">My Ratings</h1>
            <h2 class="totalRatings">Total number of ratings:  <?php echo htmlspecialchars(count($teacherRatings));?></h2>
            <h2 class="totalRatings">Overall rating: <?php echo htmlspecialchars($teacher->getOverallrating()) ?></h2>

            <table style="width:100%">
            <tr>
                <th></th>
                <th>Number of ratings</th>
                <th>Percentage</th>
            </tr>
            <tr>
                <td><span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span></td>
                <td><?php echo htmlspecialchars($rating1);?></td>
                <td><?php if(count($teacherRatings)!=0){
                    echo htmlspecialchars($rating1*100/count($teacherRatings)."%");
                    }
                        ?></td>
            </tr>
            <tr>
                <td><span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span></td>
                <td><?php echo htmlspecialchars($rating2);?></td>
                <td><?php if(count($teacherRatings)!=0){
                    echo htmlspecialchars($rating2*100/count($teacherRatings)."%");
                    }?></td>
            </tr>

            <tr>
                <td><span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span></td>
                <td><?php echo htmlspecialchars($rating3);?></td>
                <td><?php if(count($teacherRatings)!=0){
                    echo htmlspecialchars($rating3*100/count($teacherRatings)."%");
                    }?></td>
            </tr>

            <tr>
                <td><span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span></td>
                <td><?php echo htmlspecialchars($rating4);?></td>
                <td><?php if(count($teacherRatings)!=0){
                    echo htmlspecialchars($rating4*100/count($teacherRatings)."%");
                    }?></td>
            </tr>

            <tr>
                <td><span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span></td>
                <td><?php echo htmlspecialchars($rating5);?></td>
                <td><?php if(count($teacherRatings)!=0){
                    echo htmlspecialchars($rating5*100/count($teacherRatings)."%");
                    }?></td>
            </tr>


            </table>
                            
            
            
            

        </div>

    </div>


    <div class="container">

        <div class="classList">
        <h1 class="enrolledClasses">Your enrolled classes</h1>
            <div class="list">
                <?php foreach ($enrolled_classes as $enrolled_class) : ?>
                    <?php foreach ($posts3 as $class) : ?>
                        <?php if ($class['Id'] == $enrolled_class) { ?>
                            <li class="enrolled_class">
                                <?php $_SESSION['class_id'] = $enrolled_class;
                                    $_SESSION['teacher_id']  =$id;         ?>

                                <a href="ClassPageForTeacher.php?id=<?php echo $enrolled_class?> " class="class_link"> <?php echo htmlspecialchars($class['subject'] . " Grade" . $class['grade']) ?></a>
                                
                            </li>
                        <?php } ?>
                    <?php endforeach ?>
                <?php endforeach; ?>
            </div>
        
        </div>
    </div>



    

<!-- footer 
<div class="footer">
    <h2>Footer</h2>
</div>-->

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