<?php 
namespace App\Auth;

use App\Traits\ErrorTrait;
use App\User\Account;
use App\Enums\AppType;
use App\Enums\UserType;
use App\Interfaces\AppRun;
use App\Auth\Authentication;
use App\Modeles\UserModel;
use App\Services\UserService;

class Login extends Authentication implements AppRun
{
    use ErrorTrait;
    private UserModel $user;

    function __construct(AppType $apptype, UserType $accountType)
    {
        $this->apptype = $apptype;
        $this->accountType = $accountType;
        $this->userService = new UserService($this->apptype);
    }

    public function cliInputs(){
        $this->email = trim(readline("Enter your email: "));
        $this->password = trim(readline("Enter your password: "));
    }

    public function run(): void
    {
        if ($this->validate($this->cliInputs())) {
            if(!$this->matchUser()){
                $this->error($this->apptype, "Sorry! your email & password not correct.");
                return;
            }

            $account = new Account($this->apptype, $this->user);
            $account->run();
        }
    }

    protected function matchUser(){
        if(!empty($this->userService->users)){
            foreach ($this->userService->users as $user) {
                if(($user->getEmail() == $this->email) && ($user->getPassword() == $this->password)){
                    $this->user = $user;
                    return TRUE;
                }
            }
            return FALSE;
        }else{
            $this->error($this->apptype, "Sorry! no user exists.");
            return FALSE;
        }
    }
}