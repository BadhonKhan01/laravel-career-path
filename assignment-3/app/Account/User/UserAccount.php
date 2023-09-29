<?php 
namespace App\Account\User;

use App\Auth\User;
use App\Trait\MenuTrait;
use App\Account\User\DepositMoney;
use App\Account\User\WithdrawMoney;
use App\Account\User\Transactions;
use App\Account\User\TransferMoney;

class UserAccount
{
    use MenuTrait;

    protected DepositMoney $deposit;
    protected WithdrawMoney $withdraw;
    protected Transactions $transactions;
    protected TransferMoney $transfer;

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

    function __construct(User $user){
        $this->deposit = new DepositMoney($user);
        $this->withdraw = new WithdrawMoney($user);
        $this->transactions = new Transactions($user, $this->deposit, $this->withdraw);
        $this->transfer = new TransferMoney($user, $this->deposit, $this->withdraw);
    }

    public function run(): void
    {
        $this->loadMenus($this->option);
        $choice = intval(readline("Enter your option: "));
        switch ($choice) {
            case self::SHOW_TRANSACTION:
                    $this->transactions->run();
                    $this->run();
                break;
            case self::DEPOSIT_MONEY:
                    $amount = (float)trim(readline("Enter deposit amount: "));
                    $this->deposit->run($amount);
                    $this->run();
                break;
            case self::WITHDRAW_MONEY:
                    $amount = (float)trim(readline("Enter withdraw amount: "));
                    $this->withdraw->run($amount);
                    $this->run();
                break;
            case self::SHOW_CURRENT_BALANCE:
                    $this->transactions->currentBalance();
                    $this->run();
                break;
            case self::TRANSFER_MONEY:
                    $email = trim(readline("Enter transfer account email: "));
                    $amount = (float)trim(readline("Enter transfer amount: "));
                    $this->transfer->run($email, $amount);
                    $this->run();
                break;
            case self::LOG_OUT:
                    return;
                break;
        }
    }
}
