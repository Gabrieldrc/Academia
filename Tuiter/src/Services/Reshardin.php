<?php
namespace Tuiter\Services;

include(__DIR__ . '/../vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;


class Reshardin {
    
    private $exchange;
    private $queue;
    private $connection;
    private $channel;
    private $oldCollections;

    public function __construct(){
        $this->exchange = 'router';
        $this->queue = 'user';
    }

    public function reshardinUsersToTail(array $oldCollections){
        foreach($this->oldCollections as $collection){
            $collection->deleteMany([]);
        }
        $connection = new AMQPStreamConnection("10.90.251.246", "5672", 'guest', 'guest');
        $channel = $this->connection->channel();
        $channel->queue_declare($this->queue, false, true, false, false);
        //================
        $this->oldCollections = $oldCollections;
        foreach($oldCollections as $collection){
            $document = $collection->find([]);
        }
        foreach($document as $user){
            $userString = json_encode($user);
            $messageBody = $userString;
            $message = new AMQPMessage($messageBody, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
            $channel->basic_publish($message, '', $this->queue);

        }
        //================
        
        $channel->close();
        $connection->close();
        
        return True;
    }
    
    public function ReshardinUsersFromTail($newCollections){
        
        $connection = new AMQPStreamConnection("10.90.251.246", "5672", 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare($this->queue, false, true, false, false);
        //================
        $userService = new UserService($newCollections);
        //=================
        /**
         * @param \PhpAmqpLib\Message\AMQPMessage $message
         */
        $callback= function ($message) use ($userService){
            $user = json_decode($message->body,True);
            $userService->register($user['userId'],$user['name'],$user['password']);

            $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
        };

        $channel->basic_consume($this->queue, '', false, false, false, false, $callback);

        while ($channel ->is_consuming()) {
            $channel->wait();
        }

    }

    
    
}