<?php 
namespace App\Account\User;

use App\Auth\User;
use App\Account\User\DepositMoney;
use App\Account\User\WithdrawMoney;

class Transactions 
{
    protected DepositMoney $deposit;
    protected WithdrawMoney $withdraw;

    protected $data;
    protected $totalDeposit;
    protected $totalWithdraw;
    protected $totalTransfer;
    protected User $user;

    function __construct(User $user, DepositMoney $deposit, WithdrawMoney $withdraw)
    {
        $this->user = $user;
        $this->deposit = $deposit;
        $this->withdraw = $withdraw;
    }

    public function run(): void
    {
        $this->loadData();
        if(!empty($this->data)){
            $this->displayTransactions();
        }
    }

    protected function loadData(): void
    {
        $this->data = [];

        if(!empty($this->deposit->getDeposit[$this->user->getUserIndex()])){
            $depositData = $this->deposit->getDeposit[$this->user->getUserIndex()];
            foreach ($depositData as $deposit) {
                $this->data[] = [
                    "status" => $deposit->getStatus(),
                    "amount" => $deposit->getAmount(),
                    "time" => $deposit->getTime(),
                ];
            }
        }

        if (!empty($this->withdraw->withdrawData[$this->user->getUserIndex()])) {
            $withdrawData = $this->withdraw->withdrawData[$this->user->getUserIndex()];
            foreach ($withdrawData as $withdraw) {
                $this->data[] = [
                    "status" => $withdraw->getStatus(),
                    "amount" => $withdraw->getAmount(),
                    "time" => $withdraw->getTime(),
                ];
            }
        }

    }

    protected function displayTransactions(): void
    {
        $i = 0;
        printf("\n");
        foreach ($this->data as $data) {
            $i++;
            $output = $data['amount'] . " - " . ucfirst($data['status']) . " - " . $data['time'];
            printf("%d: %s\n", $i, $output);
        }
    }

    public function currentBalance(): void
    {
        $depositData = $this->deposit->getDeposit[$this->user->getUserIndex()];
        $withdrawData = $this->withdraw->withdrawData[$this->user->getUserIndex()];

        foreach ($depositData as $deposit) {
            $this->totalDeposit += $deposit->getAmount();
        }

        foreach ($withdrawData as $withdraw) {
            $this->totalWithdraw += $withdraw->getAmount();
        }

        $result = ($this->totalDeposit - $this->totalWithdraw);
        printf("\n");
        printf("%s: %s\n", "Your current balance is", $result);
    }
}
