<?php

namespace TestTuiter\Services;

use \Tuiter\Services\ReshardinMongoBeta;
use \Tuiter\Services\UserService;

final class ReshardinMongoTest extends \PHPUnit\Framework\TestCase {
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
        $this->assertTrue(class_exists("\Tuiter\Services\ReshardinMongoBeta"));
    }
    
    public function testReshardinTrue(){
        $collectionsBefore = array($this->collection[0],$this->collection[1]);
        $collectionsAfter = array($this->collection[2],$this->collection[3]);
        $us1 = new UserService($collectionsBefore);
        for($i=0;$i<1000;$i++){
            $this->assertTrue($us1->register("gab".$i, "1234", "matias"));
        }
        for($i=0;$i<1000;$i++){
            $this->assertEquals('gab'.$i,$us1->getUser('gab'.$i)->getUserId());
        }
        $resharding = new ReshardinMongoBeta();

        $this->assertTrue($resharding->reshardinUsers($collectionsBefore,$collectionsAfter));
        
        $us2 = new UserService($collectionsAfter);
        for($i=0;$i<1000;$i++){
            $this->assertEquals('gab'.$i,$us2->getUser('gab'.$i)->getUserId());
        }
        // for($i=0;$i<count($collectionsBefore);$i++){
        //     $document = $this->collection[$i]->find(['isDead']);
        //     print_r($document);
        //     //$this->assertTrue($document->isDead());
        // }
        // echo "\n\n\n\n";
        // for($i=0;$i<count($collectionsAfter);$i++){
        //     $document = $this->collection[$i]->find(['isDead']);
        //     print_r($document);
        //     //$this->assertTrue(!$document->isDead());
        // }
    }

    public function testDropOldCollection(){
        $collectionsBefore = array($this->collection[0],$this->collection[1]);
        $collectionsAfter = array($this->collection[0],$this->collection[1],$this->collection[2],$this->collection[3],$this->collection[4]);
        $us1 = new UserService($collectionsBefore);
        for($i=0;$i<1000;$i++){
            $this->assertTrue($us1->register("gab".$i, "1234", "matias"));
        }
        for($i=0;$i<1000;$i++){
            $this->assertEquals('gab'.$i,$us1->getUser('gab'.$i)->getUserId());
        }
        $resharding = new ReshardinMongoBeta();

        $this->assertTrue($resharding->reshardinUsers($collectionsBefore,$collectionsAfter));
        
        $us2 = new UserService($collectionsAfter);
        for($i=0;$i<1000;$i++){
            $this->assertEquals('gab'.$i,$us2->getUser('gab'.$i)->getUserId());
        }

    }

    public function testTwoReshardin(){
        $collectionsBefore = array($this->collection[0],$this->collection[1]);
        $collectionsAfter = array($this->collection[2],$this->collection[3]);
        $us1 = new UserService($collectionsBefore);
        for($i=0;$i<1000;$i++){
            $this->assertTrue($us1->register("gab".$i, "1234", "matias"));
        }
        for($i=0;$i<1000;$i++){
            $this->assertEquals('gab'.$i,$us1->getUser('gab'.$i)->getUserId());
        }
        $resharding = new ReshardinMongoBeta();

        $this->assertTrue($resharding->reshardinUsers($collectionsBefore,$collectionsAfter));
        
        $us2 = new UserService($collectionsAfter);
        for($i=0;$i<1000;$i++){
            $this->assertEquals('gab'.$i,$us2->getUser('gab'.$i)->getUserId());
        }
    }

}