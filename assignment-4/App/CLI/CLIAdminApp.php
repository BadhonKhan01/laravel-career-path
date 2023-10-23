<?php 
namespace App\CLI;

use App\Auth\Login;
use App\Enums\UserType;
use App\Enums\AppType;
use App\Interfaces\AppRun;
use App\Auth\Registration;
use App\Traits\DisplayMenu;

class CLIAdminApp implements AppRun
{
    use DisplayMenu;
    private const LOGIN = 1;
    private const REGISTER = 2;
    private array $option = [
        self::LOGIN => 'Login',
        self::REGISTER => 'Register'
    ];
    private Login $login;
    private Registration $registration;

    public function run(): void
    {
        while(true){
            $this->loadMenus($this->option);
            $choice = intval(readline("Enter your option: "));
            printf("\n");
            switch ($choice) {
                case self::LOGIN:
                        // $this->login = new Login(AppType::CLI_APP, UserType::ADMIN_ACCOUNT);
                        $this->login = new Login(AppType::WEB_APP, UserType::ADMIN_ACCOUNT);
                        $this->login->run();
                    break;
                case self::REGISTER:
                        // $this->registration = new Registration(AppType::CLI_APP, UserType::ADMIN_ACCOUNT);
                        $this->registration = new Registration(AppType::WEB_APP, UserType::ADMIN_ACCOUNT);
                        $this->registration->run();
                    break;
            }
        }
    }

}