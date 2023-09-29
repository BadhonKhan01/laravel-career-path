<?php 
namespace App\Account\User;

use App\Auth\User;
use App\Interface\Storage;
use App\Storage\FileStorage;
use App\Account\User\Diposit;

class DepositMoney
{
    protected User $user;
    private Storage $storage;
    public array $getDeposit;

    function __construct(User $user)
    {
        $this->user = $user;

        $this->storage = new FileStorage();
        $this->getDeposit = $this->storage->load( Diposit::getModelName() );
        // var_dump($this->getDeposit);
    }

    public function run(string $amount): void
    {
        $this->loadDeposit($amount);
        $this->saveDeposit();
    }

    protected function loadDeposit($amount){
        $diposit = new Diposit();
        $diposit->setStatus('deposit');
        $diposit->setAmount($amount);
        $diposit->setTime(date('Y-m-d H:i:s'));
        $this->getDeposit[$this->user->getUserIndex()][] = $diposit;
    }

    protected function saveDeposit(): void
    {
        $this->storage->save(Diposit::getModelName(), $this->getDeposit);
        printf("Deposit successfully\n");
        return;
    }

    public function transfer($email, $amount){

    }
}
