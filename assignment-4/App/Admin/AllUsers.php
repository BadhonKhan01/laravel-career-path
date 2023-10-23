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

class AllUsers
{
    use ErrorTrait;
    private AppType $apptype;
    public mixed $userService;
    public array $deposit;
    public array $withdraw;
    public Repository $depositRepository;
    public Repository $withdrawRepository;

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


    public function run()
    {
        if($this->apptype == AppType::CLI_APP || (php_sapi_name() === 'cli' && $this->apptype == AppType::WEB_APP)){
            $i = 0;
            printf("\n");
            foreach ($this->userService->users as $index => $user) {
                $i++;
                $accountType = 'USER_ACCOUNT';
                if($this->apptype == AppType::CLI_APP){
                    $accountType = UserType::USER_ACCOUNT;
                }
                if($user->getAccountType() == $accountType){
                    $userBalance = $this->calculate($user->getId());
                    $output = ucfirst($user->getName()) . " - " . $user->getEmail() . " - Current balance: " . $userBalance;
                    printf("%d: %s\n", $i, $output);
                }
            }
        }else{
            $temp = [];
            foreach ($this->userService->users as $index => $user) {
                if($user->getAccountType() =='USER_ACCOUNT'){
                    $temp[] = [
                        'name' => ucfirst($user->getName()),
                        'email' => $user->getEmail()
                    ];
                }
            }
            return $temp;
        }
    }

    public function calculate($id){
        $result = array_merge($this->deposit, $this->withdraw);
        $currentBalance = 0;
        foreach ($result as $item) {
            if($item->getUserId() == $id){
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