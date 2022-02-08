<?php 

class Phtml{

    protected $titulo;


    function __construct(){

    }

    function __set($name,$value){
        $this->$name = $value;
    }

}