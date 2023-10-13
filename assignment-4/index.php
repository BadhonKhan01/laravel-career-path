<?php 
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use App\CLI\CLIApp;
use App\Interfaces\AppRun;

class BankApp implements AppRun
{
    public function run(): void
    {
        // Check Request Type
        if (php_sapi_name() === 'cli') {
            $CLI = new CLIApp();
            $CLI->run();
        } else {
            echo "Run web";
        }
    }
}
$bank = new BankApp();
$bank->run();

