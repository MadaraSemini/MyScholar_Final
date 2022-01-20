<?php

    include_once("Product.php");
    include_once("Factory.php");
    include_once("Product.php");

    class Ratingfactory extends Factory{
        public function factoryMethod2($id): Product{
            return new Product();
        }

        public function factoryMethod($username,$encrypted_password): Product{
            return new product();
        }

        public function factoryMethod3($id,$value):Product{
            $rating=new Rating($id);
            $rating->setRating($value);
            return $rating;
        }
    }





?>