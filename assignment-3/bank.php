<?php 
require 'vendor/autoload.php';

use App\Auth\UserAuth;
use App\Storage\FileStorage;
use App\Enum\UserType;

class Bank
{
    private const LOGIN = 1;
    private const REGISTER = 2;
    private bool $authorization = FALSE;
    private UserAuth $auth;
    


    function __construct(){
        $this->auth = new UserAuth(new FileStorage());
    }

    public function run(): void {
        while(true){
            if (!$this->authorization) {
                printf("%d. %s\n", 1, 'Login');
                printf("%d. %s\n", 2, 'Register');
                $choice = intval(readline("Enter your option: "));
                switch ($choice) {
                    case self::LOGIN:
                        # code...
                        break;
                    case self::REGISTER:
                        $this->auth->register(UserType::USER_ACCOUNT);
                        break;
                }
            }else{

            }
        }
    }
}

$bank = new Bank();
$bank->run();
