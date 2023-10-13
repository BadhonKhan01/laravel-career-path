<?php 
namespace App\Auth;

use App\Enums\AppType;
use App\Enums\UserType;

abstract class Authentication
{
    public AppType $apptype;
    public UserType $accountType;
    public $userService;
    public string $name;
    public string $email;
    public string $password;
    
    abstract public function cliInputs();

    public function validate(){
        $errors = [];
        if(isset($this->name) && empty($this->name)){
            $errors[] = "Name is required!";
        }

        if (isset($this->email) &&  empty($this->email)) {
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email is required!";
            }
        }

        if(isset($this->password) && empty($this->password)){
            $errors[] = "Password is required!";
        }

        if (!empty($errors)) {
            printf("\n");
            foreach ($errors as $item) {
                printf("$item\n");
            }
            printf("\n");
            unset($errors);
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function hasUser(){
        if(!empty($this->userService->users)){
            foreach ($this->userService->users as $user) {
                if($user->getEmail() == $this->email){
                    printf("\n");
                    printf("This email already used\n");
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
}