<?php 
namespace App\User;

use App\Enums\AppType;
use App\Interfaces\AppRun;
use App\Modeles\UserModel;
use App\User\DepositMoney;
use App\Traits\DisplayMenu;
use App\DTO\TransactionType;
use App\Modeles\DepositModel;

class Account implements AppRun
{
    use DisplayMenu;
    public AppType $apptype;
    private const SHOW_TRANSACTION = 1;
    private const DEPOSIT_MONEY = 2;
    private const WITHDRAW_MONEY = 3;
    private const SHOW_CURRENT_BALANCE = 4;
    private const TRANSFER_MONEY = 5;
    private const LOG_OUT = 6;
    private array $option = [
        self::SHOW_TRANSACTION => 'Show my transactions',
        self::DEPOSIT_MONEY => 'Deposit money',
        self::WITHDRAW_MONEY => 'Withdraw money',
        self::SHOW_CURRENT_BALANCE => 'Show current balance',
        self::TRANSFER_MONEY => 'Transfer money',
        self::LOG_OUT => 'Logout'
    ];
    public UserModel $user;

    function __construct(AppType $apptype, UserModel $user)
    {
        $this->apptype = $apptype;
        $this->user = $user;
    }

    public function run(): void
    {
        $this->loadMenus($this->option);
        $choice = intval(readline("Enter your option: "));
        switch ($choice) {
            case self::SHOW_TRANSACTION:
                    
                break;
            case self::DEPOSIT_MONEY:
                    TransactionType::setModel(new DepositModel());
                    $deposit = new DepositMoney($this->apptype, $this->user);
                    $deposit->run();
                break;
            case self::WITHDRAW_MONEY:
                    
                break;
            case self::SHOW_CURRENT_BALANCE:
                    
                break;
            case self::TRANSFER_MONEY:
                    
                break;
            case self::LOG_OUT:
                    return;
                break;
        }

        $this->run();
    }    
}
