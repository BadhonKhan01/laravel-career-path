<?php 
namespace App\Controller;

use App\User\Deposit;
use App\DTO\WebStatus;
use App\Enums\AppType;
use App\Traits\Redirect;
use App\Modeles\UserModel;
use App\Traits\FlashTrait;
use App\Traits\ViewTraits;
use App\DTO\TransactionType;
use App\User\CurrentBalance;
use App\Modeles\DepositModel;
use App\User\ShowTransactions;
use App\Traits\CheckUserTraits;

class DepositController
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

        $this->view('users/deposit',compact('currentBalance'));
    }

    public function deposit(){
        $amount = (int) $_POST['amount'];
        if((!is_numeric($amount) && !intval($amount) == $amount) || $amount <= 0){
            $this->flashMessage('message',"Please add valid amount!");
            $this->back();
        }

        TransactionType::setModel(new DepositModel());
        $deposit = new Deposit(AppType::WEB_APP, $this->user);
        $deposit->run();

        if(WebStatus::getStatus()){
            $this->flashMessage('message',WebStatus::getStatusMessage());
        }
        $this->redirect('/customer/deposit');
    }
}

