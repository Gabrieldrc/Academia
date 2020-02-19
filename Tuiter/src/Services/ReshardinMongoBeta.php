<?php

namespace Tuiter\Services;

class ReshardinMongoBeta {

    public function reshardinUsers(array $collections, array $newCollections){
        
        $userService = new UserService($newCollections);
        foreach($collections as $collection){
            $document = $collection->find([]);
            foreach ($document as $user){
                $collection->deleteOne(['userId' => $user['userId']]);
                $userService->register($user['userId'],$user['name'],$user['password']);
            }
        }
        return True;
    }
    
}