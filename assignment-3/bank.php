<?php 
require 'vendor/autoload.php';

use App\Storage\FileStorage;
use App\Enum\UserType;
use App\Auth\Registration;
use App\Auth\Login;
use App\Trait\MenuTrait;

class Bank
{
    use MenuTrait;

    private const LOGIN = 1;
    private const REGISTER = 2;

    private array $option = [
        self::LOGIN => 'Login',
        self::REGISTER => 'Register'
    ];

    private Login $login;
    private Registration $registration;


    
    function __construct(){
        $this->login = new Login(new FileStorage());
        $this->registration = new Registration(new FileStorage());
    }

    public function run(): void {
        while(true){
            $this->loadMenus($this->option);
            $choice = intval(readline("Enter your option: "));
            printf("\n");
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
