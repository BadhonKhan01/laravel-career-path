<?php 
namespace App\Admin;

use App\User\Account;
use App\Enums\AppType;
use App\Enums\UserType;
use App\Interfaces\AppRun;
use App\Modeles\UserModel;
use App\Traits\ErrorTrait;
use App\Admin\AdminAccount;
use App\Auth\Authentication;
use App\Modeles\DepositModel;
use App\Services\UserService;
use App\Interfaces\Repository;
use App\Modeles\WithdrawModel;
use App\Repository\TransactionDBRepository;
use App\Repository\TransactionFileRepository;

class TransactionByUser implements AppRun
{
    use ErrorTrait;
    private AppType $apptype;
    public mixed $userService;
    public array $deposit;
    public array $withdraw;
    public string $email;
    public float $amount;
    public Repository $depositRepository;
    public Repository $withdrawRepository;
    public $user;

    function __construct(AppType $apptype)
    {
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

    public function cliInputs(){
        printf("\n");
        $this->email = trim(readline("Enter transfer email: "));
        printf("\n");
    }

    public function findUser(): void
    {
        if(empty($this->userService)){
            $this->error($this->apptype, "Sorry! users not available");
            return;   
        }

        foreach ($this->userService->users as $user) {
            if($user->getEmail() == $this->email){
                $this->user = $user;
            }
        }
    }

    public function run(): void
    {
        $this->cliInputs();
        $this->findUser();

        if(!$this->deposit && !$this->withdraw || empty($this->user) ){
            $this->error($this->apptype, 'Sorry. No transaction user found.');
            return;
        }

        $result = array_merge($this->deposit, $this->withdraw);
        usort($result, function($a, $b) {
            return strtotime($a->getCreatedAt()) - strtotime($b->getCreatedAt());
        });
        printf("\n");
        foreach($result as $item){
            if($this->user->getId() == $item->getUserId()){
                $status = $item->getStatus();
                $getUser = $this->getUser($item->getUserId());

                if($item->getTransferBy() != "NULL"){
                    $symbol = " < ";
                    if($item instanceof WithdrawModel){
                        $symbol = " > ";
                    }
    
                    $status = $item->getStatus() .$symbol. $item->getTransferBy();
                }
                printf("%s - %s - %s - %s\n", $getUser->getName(), $item->getAmount(), $status, $item->getCreatedAt());
            }
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