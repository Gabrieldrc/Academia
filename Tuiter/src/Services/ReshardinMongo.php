<?php

namespace Tuiter\Services;

class ReshardinMongo {

    public function reshardinUsers(array $collections, array $newCollections){
        $coll = array();
        $userService = new UserService($newCollections);
        for($i=0;$i<count($collections);$i++){
            $coll[] = $collections[$i]->find([]);
        }
        // for($i=0; $i<count($collections); $i++){
        //     $collections[$i]->drop();        
        // }
        foreach($coll as $documento){
            foreach($documento as $user){
                $userService->register($user['userId'],$user['name'],$user['password']);
            }
        }
        return True;
    }
    
}