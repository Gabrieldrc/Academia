<?php

namespace Tuiter;

class Stack {
    private $pila = array();

    public function push($element){
        $this->pila [] = $element;
        return True;
    }

    public function pop(){
        if($this->empty()){
            return False;
        }
        return array_pop($this->pila);
    }

    public function empty(){
        if(empty($this->pila)){
            return True;
        }
        return False;
    }
}


?>