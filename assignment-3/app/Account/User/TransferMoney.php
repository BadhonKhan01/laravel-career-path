<?php 
namespace App\Account\User;

use App\Auth\User;
use App\Interface\Storage;
use App\Storage\FileStorage;
use App\Account\User\Diposit;
use App\Account\User\Withdraw;
use App\Account\User\DepositMoney;
use App\Account\User\WithdrawMoney;

class TransferMoney
{
    protected $userData;
    protected User $user;
    private Storage $storage;
    public DepositMoney $deposit;
    public WithdrawMoney $withdraw;
    protected $totalDeposit;
    protected array $getUsers;
    protected array $getDeposit;

    function __construct(User $user, DepositMoney $deposit, WithdrawMoney $withdraw)
    {
        $this->user = $user;
        $this->deposit = $deposit;
        $this->withdraw = $withdraw;

        $this->storage = new FileStorage();
        $this->getUsers = $this->storage->load( User::getModelName() );
        // $this->getDeposit = $this->storage->load( Diposit::getModelName() );
    }


    public function run(string $email, float $amount): void
    {
        $this->findUser($email);

        if(empty($this->userData)){
            printf("Sorry! users not available\n");
            return;
        }

        $this->balanceCheck();
        if($this->totalDeposit > $amount){
            $this->transferForm($amount);
            $this->transferBy($amount);

            printf("\n");
            printf("Your balance transfer successfully\n");
            return;
        }else{
            printf("\n");
            printf("Sorry! balance not available\n");
            return;
        }

    }

    protected function transferForm($amount){
        $diposit = new Diposit();
        $diposit->setStatus("transfer (" . $this->userData->getName() ." <- " . $this->user->getName() .")");
        $diposit->setAmount($amount);
        $diposit->setTime(date('Y-m-d H:i:s'));
        $this->deposit->getDeposit[$this->userData->getUserIndex()][] = $diposit;
        $this->storage->save(Diposit::getModelName(), $this->deposit->getDeposit);
    }

    protected function transferBy($amount){
        $withdraw = new Withdraw();
        $withdraw->setStatus("transfer (" . $this->user->getName() ." -> " . $this->userData->getName() .")");
        $withdraw->setAmount($amount);
        $withdraw->setTime(date('Y-m-d H:i:s'));
        $this->withdraw->withdrawData[$this->user->getUserIndex()][] = $withdraw;
        $this->storage->save(Withdraw::getModelName(), $this->withdraw->withdrawData);
    }

    protected function findUser(string $email){
        if(!empty($this->getUsers)){
            foreach ($this->getUsers as $index => $data) {
                if($data->getEmail() == $email){
                    $data->setUserIndex($index);
                    $this->userData = $data;
                }
            }
        }else{
            printf("Sorry! users not available\n");
            return;
        }
    }

    protected function balanceCheck(): void
    {
        $depositAmount = 0;
        $withdrawAmount = 0;
        if (!empty($this->deposit->getDeposit[$this->user->getUserIndex()])) {
            foreach ($this->deposit->getDeposit[$this->user->getUserIndex()] as $deposit) {
                $depositAmount += $deposit->getAmount();
            }
        }
        if (!empty($this->withdraw->withdrawData[$this->user->getUserIndex()])) {
            foreach ($this->withdraw->withdrawData[$this->user->getUserIndex()] as $withdraw) {
                $withdrawAmount += $withdraw->getAmount();
            }
        }

        $this->totalDeposit = $depositAmount - $withdrawAmount;
    }
}
