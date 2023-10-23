<?php 
namespace App\Auth;

use App\DTO\WebStatus;
use App\Enums\AppType;
use App\Enums\UserType;
use App\Interfaces\AppRun;
use App\Traits\AccountType;
use App\Auth\Authentication;
use App\Services\UserService;

class Registration extends Authentication implements AppRun
{

    use AccountType;

    function __construct(AppType $apptype, UserType $accountType)
    {
        $this->apptype = $apptype;
        $this->accountType = $accountType;
        $this->userService = new UserService($this->apptype);
    }

    public function cliInputs(){
        if(isset($_POST) && !empty($_POST)){
            $this->name = $_POST['name'];
            $this->email = $_POST['email'];
            $this->password = $_POST['password'];
        }else{
            $this->name = trim(readline("Enter your name: "));
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
        
        if ($this->apptype == AppType::CLI_APP) {
            if($this->hasUser()){
                $this->userService->insertForFile([
                    'id' => time(),
                    'accountType' => $this->accountType,
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password
                ]);   
            }
        }else{
            if($this->hasUser()){
                $this->userService->insertForDB([
                    'account_type' => $this->getUserType($this->accountType),
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password
                ]);   
            }
        }
    }
}