<?php

namespace Tuiter;

class QueueStack {
    private $stackPut;
    private $stackGet;
    public function __construct(){
        $this->stackPut = new Stack;
        $this->stackGet = new Stack;
    }

    public function put($element){
        while(!$this->stackPut->empty()){
            $this->stackGet->push($this->stackPut->pop());
        }
        $this->stackPut->push($element);
        return True;
    }
    

    public function get(){
        while(!$this->stackGet->empty()){
            $this->stackPut->push($this->stackGet->pop());
        }
        return $this->stackPut->pop();
    }

    public function size(){
        $count=0;
        while(!($this->stackGet->empty())){
            $x = $this->stackGet->pop();
            $this->stackPut->push($x);;
        }
        while(!($this->stackPut->empty())){
            $x = $this->stackPut->pop();
            $this->stackGet->push($x);;
            $count+=1;
        }
        return $count;
    }
}


?>