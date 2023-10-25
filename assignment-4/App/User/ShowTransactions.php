<?php 
namespace App\User;

use App\Enums\AppType;
use App\Modeles\UserModel;
use App\Traits\ErrorTrait;
use App\Modeles\DepositModel;
use App\Services\UserService;
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
    public $userService;
    

    function __construct(AppType $apptype, UserModel $user)
    {
        $this->targetUser = $user;
        $this->apptype = $apptype;
        $this->userService = new UserService($this->apptype);
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
            if(!$this->deposit && !$this->withdraw ){
                $this->error($this->apptype, 'Sorry. No transaction found.');
                return;
            }
        }

        $result = array_merge($this->deposit, $this->withdraw);
        usort($result, function($a, $b) {
            return strtotime($a->getCreatedAt()) - strtotime($b->getCreatedAt());
        });
        printf("\n");

        if($this->apptype == AppType::CLI_APP || (php_sapi_name() === 'cli' && $this->apptype == AppType::WEB_APP)){
            foreach($result as $item){
                if($this->targetUser->getId() == $item->getUserId()){
                    $status = $item->getStatus();
                    $symbol = " < ";
                    if($item instanceof WithdrawModel){
                        $symbol = " > ";
                    }
                    if($item->getTransferBy() != "NULL"){
                        $status = $item->getStatus() .$symbol. $item->getTransferBy();
                    }
                    printf("%s - %s - %s\n", $item->getCreatedAt(), $item->getAmount(), $status);
                }
            }
        }else{
            $temp = [];
            foreach($result as $item){
                if($this->targetUser->getId() == $item->getUserId()){
                    $getUser = $this->getUser($item->getUserId());
                    $temp[] = [
                        'id' => $item->getId(),
                        'userName' => $getUser->getName(),
                        'userEmail' => $getUser->getEmail(),
                        'userId' => $item->getUserid(),
                        'amount' => $item->getAmount(),
                        'status' => $item->getStatus(),
                        'transferBy' => $item->getTransferBy(),
                        'createdAt' => $item->getCreatedAt(),
                    ];
                }
            }
            return $temp;
        }

    }

    public function getUser($id){
        foreach ($this->userService->users as $user) {
            if($user->getId() == $id){
                return $user;
            }
        }
    }
}