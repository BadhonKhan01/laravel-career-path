<?php 
require 'vendor/autoload.php';

use App\Storage\FileStorage;
use App\Enum\UserType;
use App\Auth\Registration;
use App\Auth\Login;

class Bank
{
    private const LOGIN = 1;
    private const REGISTER = 2;

    private Login $login;
    private Registration $registration;
    
    function __construct(){
        $this->login = new Login(new FileStorage());
        $this->registration = new Registration(new FileStorage());
    }

    public function run(): void {
        while(true){
            printf("%d. %s\n", 1, 'Login');
            printf("%d. %s\n", 2, 'Register');
            $choice = intval(readline("Enter your option: "));
            switch ($choice) {
                case self::LOGIN:
                        $this->login->run();
                    break;
                case self::REGISTER:
                        $this->registration->run(UserType::USER_ACCOUNT);
                    break;
            }
        }
    }
}

$bank = new Bank();
$bank->run();
