<?php 
require 'vendor/autoload.php';

use App\Web\Web;
use App\CLI\CLIApp;
use App\Interfaces\AppRun;
use App\Router\Router;

class BankApp implements AppRun
{
    public function run(): void
    {
        // Check Request Type
        if (php_sapi_name() === 'cli') {
            $CLI = new CLIApp();
            $CLI->run();
        } else {
            session_start();
            Router::dispatch();
        }
    }
}
$bank = new BankApp();
$bank->run();

