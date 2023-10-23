<?php 
require 'vendor/autoload.php';

use App\CLI\CLIAdminApp;
use App\Interfaces\AppRun;

class BankApp implements AppRun
{
    public function run(): void
    {
        // Check Request Type
        if (php_sapi_name() === 'cli') {
            $CLI = new CLIAdminApp();
            $CLI->run();
        } else {
            echo "Run web";
        }
    }
}
$bank = new BankApp();
$bank->run();

