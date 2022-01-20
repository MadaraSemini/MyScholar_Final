<?php

class Requested extends State{
    private static $instance;

    private function __construct(){}
    
    public function proceedToNext(Request $request){
        $request->setState(Accepted::getInstance());

    }
    
    public function toString(): string{
        return "Requested";
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