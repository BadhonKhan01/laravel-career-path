<?php 
namespace App\Auth;

use App\Auth\User;
use App\Interface\Storage;
use App\Trait\UserInputs;

class UserAuth
{
    use UserInputs;
    private Storage $storage;
    private array $getUsers;
    private $data;
    private array $errors = [];
    
    function __construct(Storage $storage){
        $this->storage = $storage;
        $this->getUsers = $this->storage->load( User::getModelName() );
        var_dump($this->getUsers);
    }

    public function register($type){

        $this->data = [];
        $this->data['name'] = trim(readline("Enter your name: "));
        $this->data['email'] = trim(readline("Enter your email: "));
        $this->data['password'] = trim(readline("Enter your password: "));
        $this->data['type'] = $type;
        if($this->checkValidation($this->data)){
            $check = $this->checkUser($this->data);
            if(!$check){
                printf("This email already used\n");
                return;
            }
    
            $newUser = new User();
            $newUser->setName($this->data['name']);
            $newUser->setEmail($this->data['email']);
            $newUser->setPassword($this->data['password']);
            $newUser->setType($this->data['type']);
            $this->getUsers[] = $newUser;
    
            $this->saveUser();
        }else{
            printf("Validation fail please try again\n");
            return;
        }
    }

    public function checkUser($data): bool
    {
        if(!empty($this->getUsers)){
            foreach ($this->getUsers as $user) {
                if($user->getEmail() == $data['email']){
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    public function saveUser(): void
    {
        $this->storage->save(User::getModelName(), $this->getUsers);
    }
}
