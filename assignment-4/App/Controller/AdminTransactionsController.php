<?php 
namespace App\Controller;

use App\DTO\WebStatus;
use App\Enums\AppType;
use App\Traits\Redirect;
use App\Modeles\UserModel;
use App\Traits\FlashTrait;
use App\Traits\ViewTraits;
use App\Admin\ShowTransactions;
use App\Traits\CheckUserTraits;
use App\Admin\TransactionByUser;


class AdminTransactionsController
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

        $name = $_GET['name'];
        $email = $_GET['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->flashMessage('message',"Please add valid amount!");
            $this->back();
        }

        $transactionByUser = new TransactionByUser(AppType::WEB_APP);
        $customers = $transactionByUser->run();

        $this->view('admin/customer_transactions', compact('name','customers'));
    }

    public function transactions(){

        $showTransaction = new ShowTransactions(AppType::WEB_APP);
        $transactions = $showTransaction->run();

        if(WebStatus::getError()){
            $this->flashMessage('message',WebStatus::getStatusMessage());
        }
        
        $this->view('admin/transactions', compact('transactions'));
    }
}

