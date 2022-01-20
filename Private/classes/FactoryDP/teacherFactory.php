<?php

     include_once("Product.php");
     include_once("Factory.php");
     include_once("Product.php");
    //  include_once("../../config/ConnectSingleton.php");



    class TeacherFactory extends Factory{
        public function factoryMethod($username,$encrypted_password): Product
        {
            $connector = ConnectSingleton::getInstance();
            $connec = $connector->getConnection();

            $query="select * from teacher WHERE Username='$username' AND Passkey='$encrypted_password'";
            $query_run=mysqli_query($connec,$query);
            $row = $query_run->fetch_array();
            if(is_array($row)){

                //valid
                $id=$row['Id'];
                $firstName=$row['first_name'];
                $lastName=$row['last_name'];
                $email=$row['email'];
                $district=$row['District'];
                $designation=$row['designation'];
                $description=$row['description'];
                $contact=$row['contact_number'];
                $profilePhoto="../Private/uploads/".$row['profile_photo'];
                if ($profilePhoto=="../Private/uploads/"){
                    $profilePhoto = '../Private/Images/default.jpg';
                }
            
            
                $teacher=Teacher::getInstance($id,$firstName,$lastName,$username,$encrypted_password,$email,$district,$designation,$description,$contact);
                //$student=new Student($id,$firstName,$lastName,$username,$encrypted_password,$email,$district);
                $teacher->setProfPhoto($profilePhoto);
                $teacher->setId($id);

                return $teacher;
                
        }
        else{
            echo "<script> alert('Invalide credentials');</script>";
          }
    }
    public function factoryMethod2($id): Product{
        return new Product();
    }
    public function factoryMethod3($id,$value): Product{
        return new product();
    }

}



?>