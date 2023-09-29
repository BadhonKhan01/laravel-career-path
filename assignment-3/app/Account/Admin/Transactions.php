<?php 
namespace App\Account\Admin;

use App\Auth\User;
use App\Interface\Storage;
use App\Storage\FileStorage;
use App\Account\Admin\Diposit;
use App\Account\User\Withdraw;
use App\Account\User\DepositMoney;
use App\Account\User\WithdrawMoney;

class Transactions 
{
    protected DepositMoney $deposit;
    protected WithdrawMoney $withdraw;
    protected User $user;
    private Storage $storage;

    protected $data;
    protected $totalDeposit;
    protected $totalWithdraw;
    protected $totalTransfer;
    public array $getDeposit;
    public array $getWithdraw;
    public array $getUsers;

    function __construct()
    {
        $this->storage = new FileStorage();
        $this->getUsers = $this->storage->load( User::getModelName() );
        $this->getDeposit = $this->storage->load( Diposit::getModelName() );
        $this->getWithdraw = $this->storage->load( Withdraw::getModelName() );
        $this->loadData();
    }

    public function run(): void
    {
        if(!empty($this->data)){
            $this->displayTransactions();
        }
    }

    protected function loadData(): void
    {
        $this->data = [];

        if(!empty($this->getDeposit)){
            $depositData = $this->getDeposit;
            foreach ($depositData as  $index => $depositItem) {
                foreach ($depositItem as $deposit) {
                    $this->data[] = [
                        "name" => $this->getUsers[$index]->getName(),
                        "email" => $this->getUsers[$index]->getEmail(),
                        "status" => $deposit->getStatus(),
                        "amount" => $deposit->getAmount(),
                        "time" => $deposit->getTime(),
                    ];
                }
            }
        }

        if (!empty($this->getWithdraw)) {
            $withdrawData = $this->getWithdraw;
            foreach ($withdrawData as $index => $withdrawItem) {
                foreach ($withdrawItem as $withdraw) {
                    $this->data[] = [
                        "name" => $this->getUsers[$index]->getName(),
                        "email" => $this->getUsers[$index]->getEmail(),
                        "status" => $withdraw->getStatus(),
                        "amount" => $withdraw->getAmount(),
                        "time" => $withdraw->getTime(),
                    ];
                }
            }
        }
    }

    protected function displayTransactions(): void
    {
        $i = 0;
        printf("\n");
        foreach ($this->data as $data) {
            $i++;
            $output = $data['name'] . " | " . $data['amount'] . " | " . ucfirst($data['status']) . " - " . $data['time'];
            printf("%d: %s\n", $i, $output);
        }
    }

    public function transactionsByEmail(string $email): void
    {
        $i = 0;
        if (!empty($this->data)) {
            printf("\n");
            foreach ($this->data as $data) {
                if ($data['email'] == $email) {
                    $i++;
                    $output = $data['name'] . " | " . $data['amount'] . " | " . ucfirst($data['status']) . " - " . $data['time'];
                    printf("%d: %s\n", $i, $output);
                }
            }
        }else{
            printf("\n");
            printf("Sorry! transaction not found!\n");
            return;
        }
    }
}
