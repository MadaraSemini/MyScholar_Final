<!DOCTYPE html>
<html>
    <head>
        <title>Student request form</title>
        <link rel="stylesheet" href="adForm.css">
        <script type="text/javascript" src="adForm.js"></script>
    </head>
        <body>
            <div class="container">
                <h1>Fill Advertisement Details</h1>
                <h5>(Make sure to fill all the required fields before submitting)</h5>
                <form name="adForm" action="actionAdForm.php" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
                        
                    <div class="toBeFilled">
                        <label for="heading">Add Heading</label>
                    </div><br>
                    <textarea id="heading" name="heading" placeholder="Type a heading for your advertisement.." required></textarea>
                    <br>

                    <div class="toBeFilled">
                        <label for="description">Add description</label>
                    </div>
                    <textarea id="description" name="description" placeholder="Type a description about your classes.." required></textarea><br>
                        
                    <div class="toBeFilled">
                        <label for="heading">Select Classes to Advertise</label>
                    </div><br>

                    <div class="boxes">
                        <?php
                            $con = mysqli_connect("localhost","root","","myscholar");
                            $teacher_id = 10;  //teacher id//hardcoded
                            $class_query = "SELECT * FROM class WHERE teacher_id = $teacher_id";
                            $query_run = mysqli_query($con, $class_query);
                            $checkBoxNo = 0;

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $class)
                                {
                                    $checkBoxNo+=1
                                    ?>
                                    <input type="checkbox" name="classlist[]" id="<?=$checkBoxNo?>" value="<?= $class['Id']; ?>" /> <?= $class['subject']; ?> <br/>
                                    <?php
                                }       
                            }
                            else
                            {
                                echo "No Record Found";
                            }
                            $con->close()
                        ?>
                    </div>

                    <br>
                    <input type="file" id="file" name="file">
                    <div class="row">
                        <input type="submit" name="submit" id = "<?=$checkBoxNo?>" value="Submit">
                    </div>
                </form>
            </div>
        </body>
</html>