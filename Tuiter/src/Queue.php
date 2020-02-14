<?php

namespace Tuiter;

class Queue {
    private $cola = array();

    public function put($element){
        $this->cola [] = $element;
        return True;
    }

    public function get(){
        if($this->size()>0){
            return array_shift($this->cola);
        }
        return false;
    }

    public function size(){
        return count($this->cola);
    }
}


?>