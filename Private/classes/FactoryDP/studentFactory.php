<?php

     include_once("Product.php");
     include_once("Factory.php");
     include_once("Product.php");
    //  include_once("../../config/ConnectSingleton.php");


    class StudentFactory extends Factory{
        public function factoryMethod($username,$encrypted_password): Product
        {
          $connector = ConnectSingleton::getInstance();
          $connec = $connector->getConnection();
          
            $query="select * from student WHERE Username='$username' AND Passkey='$encrypted_password'";
            $query_run=mysqli_query($connec,$query);
            $row = $query_run->fetch_array();
            if(is_array($row)){
          
              //valid
              $id=$row['id'];
              $firstName=$row['First_name'];
              $lastName=$row['Last_name'];
              $email=$row['email'];
              $grade=$row['grade'];
              $district=$row['District'];
              $profilePhoto="../Private/uploads/".$row['profile_photo'];
              if ($profilePhoto=="../Private/uploads/"){
                $profilePhoto = '../Private/Images/default.jpg';
            }
          
          
              $student=Student::getInstance($id,$firstName,$lastName,$username,$encrypted_password,$email,$district);
              //$student=new Student($id,$firstName,$lastName,$username,$encrypted_password,$email,$district);
              $student->setGrade($grade);
              $student->setProfPhoto($profilePhoto);
              $student->setId($id);
              $student->setProfPhoto($profilePhoto);

              return $student;
        }
        else{
          echo "<script> alert('Invalide credentials');</script>";
        }
    }
    public function factoryMethod2($id): Product{
        return new Product();
        }

    public function factoryMethod3($id,$value): Product{
        return new Product();
    }
}



?>