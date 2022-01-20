<?php

class Closed extends State{
    private static $instance;

    private function __construct(){}
    
    public function proceedToNext(Request $request){
        //Nothing to do?
    }
    public function toString(): string{
        return "Closed";
    }
    
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


}
?>