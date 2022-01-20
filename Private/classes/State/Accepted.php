<?php

class Accepted extends State{
    private static $instance;

    private function __construct(){}
    
    public function proceedToNext(Request $request){
        $request->setState(Closed::getInstance());
        
    }
    public function toString(): string{
        return "Accepted";
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