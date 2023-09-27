<?php 
namespace App\Auth;

use App\Interface\Storage;
use App\Enum\UserType;

class Login
{
    private Storage $storage;
    protected array $getUsers;
    protected string $email;
    protected string $password;
    protected UserType $type;

    function __construct(Storage $storage){
        $this->storage = $storage;
        $this->getUsers = $this->storage->load( User::getModelName() );
    }
    
    public function run(){
        $this->email = trim(readline("Enter your email: "));
        $this->password = trim(readline("Enter your password: "));

        if(!$this->checkUser()){
            printf("Sorry! your email & password not valid!\n");
            return FALSE;
        }

        var_dump($this->type);
    }

    protected function checkUser(): bool
    {
        if(!empty($this->getUsers)){
            foreach ($this->getUsers as $user) {
                if($user->getEmail() == $this->email && $user->getPassword() == $this->password){
                    $this->type = $user->getType();
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
}