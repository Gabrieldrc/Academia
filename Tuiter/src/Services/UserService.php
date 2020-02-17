<?php

namespace Tuiter\Services;

class UserService {

    private $collections;

    public function __construct(array $collections){
        $this->collections= $collections;
    }
    
    public function register(string $userId, string $name, string $password) {
        $user = $this->getUser($userId);
        if($user instanceof \Tuiter\Models\UserNull){
            $usuarios= array();
            $usuarios['userId']= $userId;
            $usuarios['name']= $name;
            $usuarios['password']=$password;
            $code = md5($userId);
            $numCode = 0;
            for($i=0;$i<strlen($code);$i++){
                $numCode += ord($code[$i]);
            }
            $dataBase = $numCode % count($this->collections);
            $this->collections[$dataBase]->insertOne($usuarios);
            return true;
        } else {
            return false;
        }
    }
    public function getUser($userId){
        $code = md5($userId);
        $numCode = 0;
        for($i=0;$i<strlen($code);$i++){
            $numCode += ord($code[$i]);
        }
        $dataBase = $numCode % count($this->collections);
        $cursor= $this->collections[$dataBase]->findOne(['userId'=> $userId]);
        if (is_null($cursor)){
            $user = new \Tuiter\Models\UserNull('','','');
            return $user;
        }
        
        $user = new \Tuiter\Models\User($cursor['userId'],$cursor['name'], $cursor['password']);
        return $user;
    }
}
