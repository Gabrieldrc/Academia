<?php

namespace TestTuiter\Services;

use \Tuiter\Services\UserService;

final class UserServiceTest extends \PHPUnit\Framework\TestCase {
    private $collection;

    protected function setUp(): void{
        $conn = new \MongoDB\Client("mongodb://localhost");
        $list[]=$conn->Tuiter1->usuarios;
        $list[]=$conn->Tuiter2->usuarios;
        $list[]=$conn->Tuiter3->usuarios;
        $list[]=$conn->Tuiter4->usuarios;
        $list[]=$conn->Tuiter5->usuarios;
        $list[]=$conn->Tuiter6->usuarios;
        $list[]=$conn->Tuiter7->usuarios;
        $list[]=$conn->Tuiter8->usuarios;
        $list[]=$conn->Tuiter9->usuarios;
        $list[]=$conn->Tuiter10->usuarios;        
        $this->collection = $list;
        for($i=0; $i<count($this->collection); $i++){
            $this->collection[$i]->drop();        
        }
    }


    public function testExisteClase() {
        $this->assertTrue(class_exists("\Tuiter\Services\UserService"));
    }
    public function testRegisterOk(){
        $us = new UserService($this->collection);
        $user= $us->register("mati23", "matias", "1234");
        $this->assertTrue($user);

    }
    public function testRegisterUsers(){
        $us = new UserService($this->collection);
        $user= $us->register("mati23", "1234", "matias");
        $this->assertTrue($user);
        $user2= $us->register("lucho23", "1234", "luciano");
        $this->assertTrue($user2);
    }
    public function testRegisterSameUser(){
        $us = new UserService($this->collection);
        $user= $us->register("mati23", "1234", "matias");
        $this->assertTrue($user);
        $user2= $us->register("mati23", "1234", "luciano");
        $this->assertFalse($user2);
    }

    public function testGetUser(){
        $us = new UserService($this->collection);
        $us->register("mati23", "1234", "matias");
        $user=$us->getUser('mati23');
        $this->assertEquals($user->getUserId(), 'mati23');
    }

    public function testGetUserNotExist(){
        $us = new UserService($this->collection);
        $us->register("mati23", "1234", "matias");
        $user=$us->getUser('culo44');
        $this->assertEquals($user->getUserId(), 'Null');
    }

    public function testOneThousandUsers(){
        $us = new UserService($this->collection);
        for($i=0;$i<1000;$i++){
            $this->assertTrue($us->register("gab".$i, "1234", "matias"));
        }
        for($i=0;$i<1000;$i++){
            $this->assertEquals('gab'.$i,$us->getUser('gab'.$i)->getUserId());
        }
    }

}