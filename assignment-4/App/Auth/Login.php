<?php 
namespace App\Auth;

use App\User\Account;
use App\DTO\WebStatus;
use App\Enums\AppType;
use App\Enums\UserType;
use App\Interfaces\AppRun;
use App\Modeles\UserModel;
use App\Traits\ErrorTrait;
use App\Admin\AdminAccount;
use App\Auth\Authentication;
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


        if(isset($_POST) && !empty($_POST)){
            $this->email = $_POST['email'];
            $this->password = $_POST['password'];
        }else{
            $this->email = trim(readline("Enter your email: "));
            $this->password = trim(readline("Enter your password: "));
        }
    }

    public function run(): void
    {

        if (!$this->validate($this->cliInputs())) {
            if($this->apptype == AppType::WEB_APP){
                WebStatus::setError(true);
                return;
            }else{
                $this->error($this->apptype, "Sorry! your email & password not valid.");
                return;
            }
        }

        if(!$this->matchUser()){
            if($this->apptype == AppType::WEB_APP){
                WebStatus::setError(true);
                WebStatus::setStatusMessage("Sorry! your email & password not match.");
            }else{
                $this->error($this->apptype, "Sorry! your email & password not match.");
            }
            return;
        }

        if($this->accountType == UserType::ADMIN_ACCOUNT){
            $type = 'ADMIN_ACCOUNT';
            if($this->apptype == AppType::CLI_APP){
                $type = $this->user->getAccountType();
            }

            if($type == $this->user->getAccountType()){
                $adminAccount = new AdminAccount($this->apptype, $this->user);
                $adminAccount->run();
            }
        }else{
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