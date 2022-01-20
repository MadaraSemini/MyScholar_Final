<?php

class ProxyClassPage extends ClassPage {

    private static $proxyClassObjects = array();


    public function __construct($subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $currentCapacity){
        parent::__construct($subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $currentCapacity);
    }



    public static function getInstance($id, $subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $currentCapacity){
        
        if(array_key_exists($id, self::$proxyClassObjects)){
            return self::$proxyClassObjects[$id];
        }
        else {
            $proxyClass = new static($subject, $day, $starttime, $endtime, $fee, $classtype, $grade, $medium, $capacity, $location, $currentCapacity);
            self::$proxyClassObjects[$id] = $proxyClass;
            return $proxyClass;
        }
    }




}

?>