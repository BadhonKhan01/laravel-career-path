<?php 
namespace App\Account\User;

use App\Auth\User;
use App\Interface\Storage;
use App\Storage\FileStorage;
use App\Account\User\Withdraw;

class WithdrawMoney
{

    protected User $user;
    private Storage $storage;
    public array $withdrawData;
    public array $dipositData;
    protected $totalDeposit;

    function __construct(User $user)
    {
        $this->user = $user;
        
        $this->storage = new FileStorage();
        $this->withdrawData = $this->storage->load( Withdraw::getModelName() );
        $this->dipositData = $this->storage->load( Diposit::getModelName() );
    }

    public function run(string $amount): void
    {
        $this->balanceCheck();
        if($this->totalDeposit > $amount){
            $this->loadWithdraw($amount);
            $this->saveWithdraw();
        }else{
            printf("\n");
            printf("Sorry! balance not available\n");
            return;
        }
    }

    protected function loadWithdraw($amount){
        $withdraw = new Withdraw();
        $withdraw->setStatus('withdraw');
        $withdraw->setAmount($amount);
        $withdraw->setTime(date('Y-m-d H:i:s'));
        $this->withdrawData[$this->user->getUserIndex()][] = $withdraw;
    }

    protected function saveWithdraw(): void
    {
        $this->storage->save(Withdraw::getModelName(), $this->withdrawData);
        printf("Withdraw successfully\n");
        return;
    }

    protected function balanceCheck(): void
    {
        $depositAmount = 0;
        $withdrawAmount = 0;


        if (!empty($this->dipositData[$this->user->getUserIndex()])) {
            foreach ($this->dipositData[$this->user->getUserIndex()] as $deposit) {
                $depositAmount += $deposit->getAmount();
            }
        }
        if (!empty($this->withdrawData[$this->user->getUserIndex()])) {
            foreach ($this->withdrawData[$this->user->getUserIndex()] as $withdraw) {
                $withdrawAmount += $withdraw->getAmount();
            }
        }

        $this->totalDeposit = $depositAmount - $withdrawAmount;
    }
}
