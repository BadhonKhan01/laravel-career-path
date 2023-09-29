<?php 
namespace App\Account\Admin;


use App\Trait\MenuTrait;
use App\Account\Admin\Users;
use App\Account\Admin\Transactions;


class AdminAccount
{
    use MenuTrait;

    protected Transactions $transactions;
    protected Users $users;

    private const SHOW_ALL_TRANSACTION = 1;
    private const TRANSFER_BY_USER = 2;
    private const SHOW_ALL_USER = 3;
    private const LOG_OUT = 4;

    private array $option = [
        self::SHOW_ALL_TRANSACTION => 'Show all transactions',
        self::TRANSFER_BY_USER => 'Transactions by user',
        self::SHOW_ALL_USER => 'Show all customers',
        self::LOG_OUT => 'Logout'
    ];

    function __construct(){
        $this->transactions = new Transactions();
        $this->users = new Users();
    }

    public function run(): void
    {
        $this->loadMenus($this->option);
        $choice = intval(readline("Enter your option: "));
        switch ($choice) {
            case self::SHOW_ALL_TRANSACTION:
                    $this->transactions->run();
                    $this->run();
                break;
            case self::TRANSFER_BY_USER:
                    $amount = trim(readline("Enter user email: "));
                    $this->transactions->transactionsByEmail($amount);
                    $this->run();
                break;
            case self::SHOW_ALL_USER:
                    $this->users->all();
                    $this->run();
                break;
            case self::LOG_OUT:
                    return;
                break;
        }
    }
}
