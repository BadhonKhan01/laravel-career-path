<?php 
namespace App\Classes;

use App\Classes\UsersManager;
use App\Classes\FileStorage;

class CLIApp
{
    private UsersManager $usersManager;
    private const LOGIN = 1;
    private const REGISTER = 2;

    private array $authentication =[
        self::LOGIN => 'Login',
        self::REGISTER => 'Register'
    ];

    function __construct(){
        $this->usersManager = new UsersManager(new FileStorage());
    }

    function run(): void
    {
        while (true) {
            foreach ($this->authentication as $option => $label) {
                printf("%d. %s\n", $option, $label);
            }
            $choice = intval(readline("Enter your option: "));

            switch ($choice) {
                case self::LOGIN:
                        echo "Login";
                    break;
                case self::REGISTER:
                        $name = trim(readline("Enter your name: "));
                        $email = trim(readline("Enter your email: "));
                        $password = trim(readline("Enter your password: "));
                        $newUser = [
                            "name" => $name,
                            "email" => $email,
                            "password" => $password
                        ];
                        $this->usersManager->register($newUser);
                    break;
                default:
                    echo "Invalid option.\n";
            }
        }
    }
}
