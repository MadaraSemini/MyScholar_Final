<?php
abstract class State{

    public abstract function proceedToNext(Request $request);
    public abstract function toString(): string;

}


?>