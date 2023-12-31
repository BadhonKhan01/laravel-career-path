<?php 
namespace App\User;

use App\Enums\AppType;
use App\Modeles\UserModel;
use App\Modeles\DepositModel;
use App\Interfaces\Repository;
use App\Modeles\WithdrawModel;
use App\Repository\TransactionDBRepository;
use App\Repository\TransactionFileRepository;

class CurrentBalance
{
    public array $deposit;
    public array $withdraw;
    public Repository $depositRepository;
    public Repository $withdrawRepository;
    public AppType $apptype;
    public UserModel $user;
    

    function __construct(AppType $apptype, UserModel $user)
    {
        $this->user = $user;
        $this->apptype = $apptype;
        if($this->apptype == AppType::CLI_APP){
            $this->loadFileData();
        }else{
            $this->loadDBData();
        }
    }

    public function loadFileData(){
        $this->depositRepository = new TransactionFileRepository();
        $this->deposit = $this->depositRepository->get(DepositModel::getModelName());

        $this->withdrawRepository = new TransactionFileRepository();
        $this->withdraw = $this->withdrawRepository->get(WithdrawModel::getModelName());
    }

    public function loadDBData(){
        $this->depositRepository = new TransactionDBRepository();
        $this->deposit = $this->depositRepository->get( new DepositModel() );

        $this->withdrawRepository = new TransactionDBRepository();
        $this->withdraw = $this->withdrawRepository->get( new WithdrawModel() );
    }
    
    public function run()
    {
        if($this->apptype == AppType::CLI_APP || (php_sapi_name() === 'cli' && $this->apptype == AppType::WEB_APP)){
            printf("\n");
            printf("%s %s\n", "Current Balance: ", number_format($this->calculate(), 2));
        }else{
            return number_format($this->calculate(), 2);
        }
    }

    public function calculate(){
        $result = array_merge($this->deposit, $this->withdraw);
        $currentBalance = 0;
        foreach ($result as $item) {
            if($item->getUserId() == $this->user->getId()){
                if ($item instanceof DepositModel) {
                    $currentBalance += floatval($item->getAmount());
                } elseif ($item instanceof WithdrawModel) {
                    $currentBalance -= floatval($item->getAmount());
                }
            }
        }
        return $currentBalance;
    }
}