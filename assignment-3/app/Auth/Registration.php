<?php 
namespace App\Auth;

use App\Auth\User;
use App\Enum\UserType;
use App\Trait\UserTrait;
use App\Interface\Storage;

class Registration
{
    use UserTrait;

    protected string $isValid;
    private Storage $storage;
    protected array $getUsers;
    protected string $name;
    protected string $email;
    protected string $password;
    protected UserType $type;

    function __construct(Storage $storage){
        $this->storage = $storage;
        $this->getUsers = $this->storage->load( User::getModelName() );
    }

    public function run(UserType $type): void
    {
        $this->name = trim(readline("Enter your name: "));
        $this->email = trim(readline("Enter your email: "));
        $this->password = trim(readline("Enter your password: "));
        $this->type = $type;

        $this->isValid = $this->userInputValidation([
            "name" => $this->name,
            "email" => $this->email,
            "password" => $this->password
        ]);

        if($this->isValid && $this->checkUser()){
            $this->loadAccount();
            $this->saveAccount();
        }
    }

    protected function checkUser(): bool
    {
        if(!empty($this->getUsers)){
            foreach ($this->getUsers as $user) {
                if($user->getEmail() == $this->email){
                    printf("\n");
                    printf("This email already used\n");
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    protected function loadAccount(): void
    {
        $newUser = new User();
        $newUser->setName($this->name);
        $newUser->setEmail($this->email);
        $newUser->setPassword($this->password);
        $newUser->setType($this->type);
        $this->getUsers[] = $newUser;
    }

    protected function saveAccount(): void
    {
        $this->storage->save(User::getModelName(), $this->getUsers);
        printf("\n");
        printf("Account created successfully\n");
        return;
    }
}
