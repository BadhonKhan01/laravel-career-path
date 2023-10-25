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

class TransactionByUser
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
        if($this->apptype == AppType::CLI_APP || (php_sapi_name() === 'cli' && $this->apptype == AppType::WEB_APP)){
            printf("\n");
            $this->email = trim(readline("Enter transfer email: "));
            printf("\n");
        }else{
            $this->email = $_GET['email'];
        }
    }

    public function findUser(): void
    {
        
        if($this->apptype == AppType::CLI_APP || (php_sapi_name() === 'cli' && $this->apptype == AppType::WEB_APP)){
            if(empty($this->userService)){
                $this->error($this->apptype, "Sorry! users not available");
                return;   
            }
        }

        foreach ($this->userService->users as $user) {
            if($user->getEmail() == $this->email){
                $this->user = $user;
            }
        }
    }

    public function run()
    {
        $this->cliInputs();
        $this->findUser();
        
        if($this->apptype == AppType::CLI_APP || (php_sapi_name() === 'cli' && $this->apptype == AppType::WEB_APP)){
            if(!$this->deposit && !$this->withdraw || empty($this->user) ){
                $this->error($this->apptype, 'Sorry. No transaction user found.');
                return;
            }
        }

        $result = array_merge($this->deposit, $this->withdraw);
        usort($result, function($a, $b) {
            return strtotime($a->getCreatedAt()) - strtotime($b->getCreatedAt());
        });
        if($this->apptype == AppType::CLI_APP || (php_sapi_name() === 'cli' && $this->apptype == AppType::WEB_APP)){
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
        }else{
            $temp = [];
            foreach($result as $item){
                if($this->user->getId() == $item->getUserId()){
                    $getUser = $this->getUser($item->getUserId());
                    $temp[] = [
                        'id' => $item->getId(),
                        'userId' => $item->getUserId(),
                        'userName' => $getUser->getName(),
                        'userEmail' => $getUser->getEmail(),
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