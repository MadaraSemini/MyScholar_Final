<?php
    include_once("Product.php");
    include_once("Factory.php");

    class RequestFactory extends Factory{
        public function factoryMethod2($id):Product{
            $connector = new Connector();
            $conn = $connector->connectDatabase();

            $sql = "SELECT * FROM request WHERE id=$id";
            $sql = mysqli_query($conn,$sql);
            $row = $sql->fetch_array();

            if(is_array($row)){
          
                //valid
                $id=$row['Id'];
                $studentId=$row['student_id'];
                $classId=$row['class_id'];
                $teacherId=$row['teacher_id'];
                $state=$row['state'];
    
                $request = new Request($classId,$studentId,$teacherId);
                $request->setState($state);
    
                return $request;
    
            } 
        }
        public function factoryMethod3($id,$value): Product{
            return new product();
        }
        public function factoryMethod($username,$encrypted_password): Product{
            return new product();
        }
        
    }
?>