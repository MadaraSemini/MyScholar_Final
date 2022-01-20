<?php
    abstract class Factory{

    public function anOperation($username,$password){
        $product = $this->factoryMethod($username,$password);
        return $product;
    }
    public abstract function factoryMethod($username,$password): Product;
    
    public function anOperation2($id){
        $product = $this->factoryMethod2($id);
        return $product;
    }
    public abstract function factoryMethod2($id): Product;

    public function anOperation3($id,$value){
        $product = $this->factoryMethod3($id,$value);
        return $product;
    }
    public abstract function factoryMethod3($id,$value): Product;
}
?>