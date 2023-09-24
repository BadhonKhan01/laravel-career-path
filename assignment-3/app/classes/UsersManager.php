<?php 
namespace App\Classes;

use App\Classes\User;
use App\Classes\NewRegister;

class UsersManager
{
    private StorageInterFace $storage;
    private array $users;

    function __construct(StorageInterFace $storage){
        $this->storage = $storage;
        $this->users = $this->storage->load(User::getModelName());
    }

    function register($newUser){

        $users = $this->getUsers($newUser);
        
        if(!$users) {
            printf("Invalid user!\n");
            return;
        }
        
        $register = [];
        $register[] = new NewRegister($newUser);
        $this->storage->save(User::getModelName(), $register);
    }

    function getUsers($newUser){
        foreach($this->users as $user){
            if(($user->getName() === $newUser['name']) && ($user->getEmail() === $newUser['email'])){
                return null;
            }
        }
        return $newUser;
    }
}
