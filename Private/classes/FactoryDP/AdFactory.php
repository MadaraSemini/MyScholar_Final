<?php
//include_once("../../config/ConnectSingleton.php");
include_once("AdTemp.php");
include_once("Factory.php");
include_once("Product.php");


class AdFactory extends Factory{
    public function factoryMethod2($id):Product{
        $connector = ConnectSingleton::getInstance();
        $conn = $connector->getConnection();
        
        $sql = "SELECT * FROM advertisement WHERE Id=$id";
        $sql = mysqli_query($conn,$sql);
        $row = $sql->fetch_array();

        $adCls = "SELECT * FROM advertisement_class WHERE ad_id=$id";
        $adCls = mysqli_query($conn,$adCls);

        if(is_array($row)){
          
            //valid
            $id=$row['Id'];
            $heading=$row['heading'];
            $description=$row['description'];
            $teacher_id=$row['teacher_id'];
            $background=$row['background'];

            $ad = new AdTemp($teacher_id,$heading,$description,$background);
            $ad->setId($id);

            if (mysqli_num_rows($adCls) > 0) {
                foreach ($adCls as $cls) {
                    $currClsId = $cls['class_id']; 
                    $ad->addClassId($currClsId);
                }
            }

            return $ad;

        } 
    }
    public function factoryMethod($username,$password): Product{
        return new Product();
    }

    public function factoryMethod3($id,$value): Product{
        return new Product();
    }

}
?>