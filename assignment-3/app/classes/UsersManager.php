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

        $checkUser = $this->isUserExists($newUser);
        
        if(!$checkUser) {
            printf("Invalid user!\n");
            return;
        }

        $user = new User();
        $user->setName($newUser['name']);
        $user->setEmail($newUser['email']);
        $user->setPassword($newUser['password']);

        $this->users[] = $user;
        printf("User added successfully!\n");
        
        $this->saveUsers();
    }

    function isUserExists($newUser){
        foreach($this->users as $user){
            if(($user->getName() === $newUser['name']) && ($user->getEmail() === $newUser['email'])){
                return null;
            }
        }
        return $newUser;
    }

    public function saveUsers(): void
    {
        $this->storage->save(User::getModelName(), $this->users);
    }

    public function login($newUser){
        foreach($this->users as $user){
            if(($user->getEmail() === $newUser['email']) && ($user->getPassword() === $newUser['password'])){
                return true;
            }
        }
        return false;
    }
}
