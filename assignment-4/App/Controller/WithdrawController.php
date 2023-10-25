<?php 
namespace App\Controller;

use App\User\Deposit;
use App\DTO\WebStatus;
use App\Enums\AppType;
use App\User\Withdraw;
use App\Traits\Redirect;
use App\Modeles\UserModel;
use App\Traits\FlashTrait;
use App\Traits\ViewTraits;
use App\DTO\TransactionType;
use App\User\CurrentBalance;
use App\Modeles\DepositModel;
use App\Modeles\WithdrawModel;
use App\User\ShowTransactions;
use App\Traits\CheckUserTraits;

class WithdrawController
{
    use CheckUserTraits;
    use ViewTraits;
    use FlashTrait;
    use Redirect;
    public UserModel $user;

    function __construct()
    {
        $this->user = $this->loginUser();
    }
    
    public function index(){

        $currentBalance = new CurrentBalance(AppType::WEB_APP, $this->user);
        $currentBalance = $currentBalance->run();

        $this->view('users/withdraw',compact('currentBalance'));
    }

    public function withdraw(){
        $amount = (int) $_POST['amount'];
        if((!is_numeric($amount) && !intval($amount) == $amount) || $amount <= 0){
            $this->flashMessage('message',"Please add valid amount!");
            $this->back();
        }

        TransactionType::setModel(new WithdrawModel());
        $withdraw = new Withdraw(AppType::WEB_APP, $this->user);
        $withdraw->run();

        if(WebStatus::getStatus() || WebStatus::getError()){
            $this->flashMessage('message',WebStatus::getStatusMessage());
        }

        $this->redirect('/customer/withdraw');
    }
}

