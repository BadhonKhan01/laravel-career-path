<?php 
namespace App\User;

use App\Enums\AppType;
use App\Modeles\UserModel;
use App\Traits\ErrorTrait;
use App\Modeles\DepositModel;
use App\Interfaces\Repository;
use App\Modeles\WithdrawModel;
use App\Repository\TransactionDBRepository;
use App\Repository\TransactionFileRepository;

class ShowTransactions
{
    use ErrorTrait;
    public array $deposit;
    public array $withdraw;
    public Repository $depositRepository;
    public Repository $withdrawRepository;
    public AppType $apptype;
    public UserModel $targetUser;
    

    function __construct(AppType $apptype, UserModel $user)
    {
        $this->targetUser = $user;
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
    
    public function run(): void
    {
        if(!$this->deposit && !$this->withdraw ){
            $this->error($this->apptype, 'Sorry. No transaction found.');
            return;
        }

        $result = array_merge($this->deposit, $this->withdraw);
        usort($result, function($a, $b) {
            return strtotime($a->getCreatedAt()) - strtotime($b->getCreatedAt());
        });
        printf("\n");
        foreach($result as $item){
            if($this->targetUser->getId() == $item->getUserId()){
                $status = $item->getStatus();
                if($item->getTransferBy() != "NULL"){
                    $status = $item->getStatus() .' transfer '. $item->getTransferBy();
                }
                printf("%s - %s - %s\n", $item->getCreatedAt(), $item->getAmount(), $status);
            }
        }
    }
}