<?php 
namespace App\Auth;

use App\Auth\User;
use App\Interface\Storage;
use App\Enum\UserType;
use App\Account\User\UserAccount;

class Login
{
    protected $data;
    private Storage $storage;
    protected array $getUsers;
    protected string $email;
    protected string $password;
    protected UserType $type;

    function __construct(Storage $storage){
        $this->storage = $storage;
        $this->getUsers = $this->storage->load( User::getModelName() );
        // var_dump($this->getUsers);
    }
    
    public function run(){
        $this->email = trim(readline("Enter your email: "));
        $this->password = trim(readline("Enter your password: "));

        if(!$this->checkUser()){
            printf("\n");
            printf("Sorry! your email & password not valid!\n");
            printf("\n");
            return FALSE;
        }

        if($this->type === UserType::USER_ACCOUNT){
            $account = new UserAccount($this->data);
            $account->run();
        }
    }

    protected function checkUser(): bool
    {
        if(!empty($this->getUsers)){
            foreach ($this->getUsers as $index => $user) {
                if($user->getEmail() == $this->email && $user->getPassword() == $this->password){
                    $user->setUserIndex($index);
                    $this->type = $user->getType();
                    $this->data = $user;
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
}