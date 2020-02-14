<?php

namespace TestTuiter\Models;

use \Tuiter\Stack;
use \Tuiter\Queue;
use \Tuiter\QueueStack;

final class SQTest extends \PHPUnit\Framework\TestCase {
    //Stack
    public function testClassExists(){
        $this->assertTrue(class_exists("Tuiter\Stack"));
        $this->assertTrue(class_exists("Tuiter\Queue"));
    }

    public function testPushAndPopElement(){
        $stack = new Stack();
        $this->assertTrue($stack->push("Primer Elemento"));
        $this->assertEquals("Primer Elemento",$stack->pop());
    }
    
    public function testPushSameElementTwice(){
        $stack = new Stack();
        $this->assertTrue($stack->push("Primer Elemento"));
        $this->assertTrue($stack->push("Primer Elemento"));
        $this->assertEquals("Primer Elemento",$stack->pop());
        $this->assertEquals("Primer Elemento",$stack->pop());
    }

    public function testPushFalseIfNoMoreElement(){
        $stack = new Stack();
        $this->assertTrue($stack->push("Primer Elemento"));
        $this->assertEquals("Primer Elemento",$stack->pop());
        $this->assertFalse($stack->pop());
    }

    public function testPushAnyElement(){
        $stack = new Stack();
        $this->assertTrue($stack->push("Primer Elemento"));
        $this->assertTrue($stack->push(array("Segundo Elemento")));
        $this->assertTrue($stack->push(1234));
    }

    public function testOrderWorks(){
        $stack = new Stack();
        $this->assertTrue($stack->push("Primer Elemento"));
        $this->assertTrue($stack->push(array("Segundo Elemento")));
        $this->assertTrue($stack->push(1234));
        $this->assertEquals(1234,$stack->pop());
        $this->assertEquals(array("Segundo Elemento"),$stack->pop());
        $this->assertEquals("Primer Elemento",$stack->pop());
        $this->assertFalse($stack->pop());
    }

    //===========================================
    //Queue

    public function testPutAndGetElement(){
        $queue = new Queue();
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertEquals("Primer Elemento",$queue->get());
    }
    
    public function testPutSameElementTwice(){
        $queue = new Queue();
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertEquals("Primer Elemento",$queue->get());
        $this->assertEquals("Primer Elemento",$queue->get());
    }

    public function testPutFalseIfNoMoreElement(){
        $queue = new Queue();
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertEquals("Primer Elemento",$queue->get());
        $this->assertFalse($queue->get());
    }

    public function testPutAnyElement(){
        $queue = new Queue();
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertTrue($queue->put(array("Segundo Elemento")));
        $this->assertTrue($queue->put(1234));
    }

    public function testOrderMatters(){
        $queue = new Queue();
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertTrue($queue->put(array("Segundo Elemento")));
        $this->assertTrue($queue->put(1234));
        $this->assertEquals("Primer Elemento",$queue->get());
        $this->assertEquals(array("Segundo Elemento"),$queue->get());
        $this->assertEquals(1234,$queue->get());
        $this->assertFalse($queue->get());
    }

    //==================================================
    //QueueStack
    public function testPutAndGetElementQS(){
        $queue = new QueueStack(new Stack());
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertEquals("Primer Elemento",$queue->get());
    }
    
    public function testPutSameElementTwiceQS(){
        $queue = new QueueStack();
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertEquals("Primer Elemento",$queue->get());
        $this->assertEquals("Primer Elemento",$queue->get());
    }

    public function testPutFalseIfNoMoreElementQS(){
        $queue = new QueueStack();
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertEquals("Primer Elemento",$queue->get());
        $this->assertFalse($queue->get());
    }

    public function testPutAnyElementQS(){
        $queue = new QueueStack(new Stack());
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertTrue($queue->put(array("Segundo Elemento")));
        $this->assertTrue($queue->put(1234));
    }

    public function testOrderMattersQS(){
        $queue = new QueueStack(new Stack());
        $this->assertTrue($queue->put("Primer Elemento"));
        $this->assertTrue($queue->put(array("Segundo Elemento")));
        $this->assertTrue($queue->put(1234));
        $this->assertEquals("Primer Elemento",$queue->get());
        $this->assertEquals(array("Segundo Elemento"),$queue->get());
        $this->assertEquals(1234,$queue->get());
        $this->assertFalse($queue->get());
    }
}