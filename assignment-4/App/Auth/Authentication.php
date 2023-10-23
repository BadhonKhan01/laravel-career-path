<?php 
namespace App\Auth;

use App\DTO\WebStatus;
use App\Enums\AppType;
use App\Enums\UserType;
use App\Traits\ErrorTrait;

abstract class Authentication
{

    use ErrorTrait;
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
            $temp = [];
            foreach ($errors as $item) {
                printf("$item\n");
                $temp[] = "<p>".$item . "</p>";
            }
            printf("\n");
            unset($errors);

            if($this->apptype == AppType::WEB_APP){
                WebStatus::getError(true);
                WebStatus::setStatusMessage(implode(" ", $temp));
            }

            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function hasUser(){
        if(!empty($this->userService->users)){
            foreach ($this->userService->users as $user) {
                if($user->getEmail() == $this->email){
                    if($this->apptype == AppType::WEB_APP){
                        WebStatus::setStatus(true);
                        WebStatus::setStatusMessage('This email already used');
                    }else{
                        $this->error($this->apptype, "This email already used.");
                    }
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
}