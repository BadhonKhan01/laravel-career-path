<?php 
namespace App\User;

use App\Enums\AppType;
use App\User\Transaction;
use App\Modeles\UserModel;
use App\DTO\TransactionType;
use App\Modeles\DepositModel;
use App\Services\UserService;
use App\Modeles\WithdrawModel;
use App\Services\TransactionService;

class Transfer
{
    public AppType $apptype;
    public UserModel $user; 
    public $dipositHolder; 
    public mixed $userService;
    public string $email;
    public float $amount;
    public mixed $service;

    function __construct(AppType $apptype, UserModel $user)
    {
        $this->apptype = $apptype;
        $this->user = $user;
        $this->userService = new UserService($this->apptype);
    }

    public function cliInputs(){
        printf("\n");
        $this->email = trim(readline("Enter transfer email: "));
        $this->amount = (float)trim(readline("Enter deposit amount: "));
        if($this->amount < 0){
            $this->error($this->apptype, "Sorry! your amount not valid.");
            printf("\n");
            return FALSE;
        }
        printf("\n");
        return TRUE;
    }

    public function findUser(): void
    {
        if(empty($this->userService)){
            printf("Sorry! users not available\n");
            return;   
        }

        foreach ($this->userService->users as $user) {
            if($user->getEmail() == $this->email){
                $this->dipositHolder = $user;
            }
        }
    }

    public function run(): void
    {
        $this->cliInputs();
        $this->findUser();

        if(!$this->dipositHolder){
            printf("Sorry! users not available\n");
            return;   
        }

        if(($this->apptype == AppType::CLI_APP)){
            
            TransactionType::setModel(new WithdrawModel());
            $withdraw = new TransactionService($this->apptype);
            $withdraw->insertForFile([
                'id' => time(),
                'user_id' => $this->user->getId(),
                'status' => WithdrawModel::getModelName(),
                'amount' => $this->amount,
                'setTransferBy' => $this->dipositHolder->getEmail(),
                'created_at' => date('Y-m-d h:i:s')
            ]);
            
            TransactionType::setModel(new DepositModel());
            $diposit = new TransactionService($this->apptype);
            $diposit->insertForFile([
                'id' => time(),
                'user_id' => $this->dipositHolder->getId(),
                'status' => DepositModel::getModelName(),
                'amount' => $this->amount,
                'setTransferBy' => $this->user->getEmail(),
                'created_at' => date('Y-m-d h:i:s')
            ]);

        }else{
            TransactionType::setModel(new WithdrawModel());
            $withdraw = new TransactionService($this->apptype);
            $withdraw->insertForDB([
                'user_id' => $this->user->getId(),
                'status' => WithdrawModel::getModelName(),
                'amount' => $this->amount,
                'setTransferBy' => $this->dipositHolder->getEmail(),
            ]); 

            TransactionType::setModel(new DepositModel());
            $diposit = new TransactionService($this->apptype);
            $diposit->insertForDB([
                'user_id' => $this->dipositHolder->getId(),
                'status' => DepositModel::getModelName(),
                'amount' => $this->amount,
                'setTransferBy' => $this->user->getEmail(),
            ]);
        }
    }
}