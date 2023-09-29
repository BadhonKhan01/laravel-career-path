<?php 
namespace App\Account\Admin;

use App\Auth\User;
use App\Enum\UserType;
use App\Interface\Storage;
use App\Storage\FileStorage;
use App\Account\User\Diposit;
use App\Account\User\Withdraw;

class Users 
{
    protected User $user;
    private Storage $storage;

    protected $data;
    public array $getUsers;
    public array $withdrawData;
    public array $dipositData;
    protected $totalDeposit;

    function __construct()
    {
        $this->storage = new FileStorage();
        $this->getUsers = $this->storage->load( User::getModelName() );
        $this->withdrawData = $this->storage->load( Withdraw::getModelName() );
        $this->dipositData = $this->storage->load( Diposit::getModelName() );
    }

    public function all(): void
    {
        if(!empty($this->getUsers)){
            $this->displayUser();
        }else{
            printf("\n");
            printf("Sorry! no data found!\n");
            return;
        }
    }

    protected function displayUser(): void
    {
        $i = 0;
        printf("\n");
        foreach ($this->getUsers as $index => $user) {
            $i++;
            if($user->getType() == UserType::USER_ACCOUNT){
                $output = ucfirst($user->getName()) . " - " . $user->getEmail() . " - current balance: " . $this->currentBalance($index);
                printf("%d: %s\n", $i, $output);
            }
        }
    }

    public function currentBalance($index): string
    {
        $depositAmount = 0;
        $withdrawAmount = 0;

        if (!empty($this->dipositData[$index])) {
            foreach ($this->dipositData[$index] as $deposit) {
                $depositAmount += $deposit->getAmount();
            }
        }
        if (!empty($this->withdrawData[$index])) {
            foreach ($this->withdrawData[$index] as $withdraw) {
                $withdrawAmount += $withdraw->getAmount();
            }
        }

        $result = $depositAmount - $withdrawAmount;
        return $result;
    }
}