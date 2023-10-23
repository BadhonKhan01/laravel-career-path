<?php 
namespace App\Controller;

use App\User\Deposit;
use App\DTO\WebStatus;
use App\Enums\AppType;
use App\User\Transfer;
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

class TransferController
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

        $this->view('users/transfer',compact('currentBalance'));
    }

    public function transfer(){
        $email = $_POST['email'];
        $amount = (int) $_POST['amount'];
        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $this->flashMessage('message',"Invalid email address!");
            $this->back();
        }

        if((!is_numeric($amount) && !intval($amount) == $amount) || $amount <= 0){
            $this->flashMessage('message',"Please add valid amount!");
            $this->back();
        }

        $transfer = new Transfer(AppType::WEB_APP, $this->user);
        $transfer->run();

        if(WebStatus::getStatus() || WebStatus::getError()){
            $this->flashMessage('message',WebStatus::getStatusMessage());
        }
        $this->redirect('/customer/transfer');
    }
}

